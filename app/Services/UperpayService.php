<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use App\Services\Payments\PaymentMethodInterface;
use App\Services\Payments\BniPaymentMethod;

class UperpayService
{
    protected $token;
    protected $mode;
    protected $appCode;
    protected $baseUrl;
    protected $handlers = [];
    public function __construct()
    {
        $this->token = config('uperpay.token');
        $this->mode = config('uperpay.mode');
        $this->appCode = config('uperpay.app_code');
        $this->baseUrl = $this->mode === 'production' 
            ? 'https://uperpay.universitaspertamina.ac.id/api' 
            : 'https://uperpay-dev.universitaspertamina.ac.id/api';

        $this->handlers = [];
        $this->registerDefaultHandlers();
    }

    public function getBniUrl()
    {
        return $this->baseUrl . '/bni/transactions';
    }

    protected function registerDefaultHandlers()
    {
        // register known handlers here; future methods can be registered similarly
        $this->handlers['BBNI'] = new BniPaymentMethod($this);
    }

    /**
     * Get handler by method key (uppercase).
     *
     * @param string|null $method
     * @return PaymentMethodInterface|null
     */
    protected function getHandler(?string $method): ?PaymentMethodInterface
    {
        $key = strtoupper($method ?? '');
        return $this->handlers[$key] ?? null;
    }

    public function generateTrxId($method = null, $type = null)
    {
        $trx_id = $this->appCode;
        $trx_id .= '-';
        $trx_id .= $method;
        $trx_id .= '-';
        $trx_id .= $type ?? '999';
        $trx_id .= '-';
        $trx_id .= substr(date('Y'), 2) . Carbon::now()->format('md');
        $trx_id .= '-';
        $trx_id .= strtoupper(generateRandomString(10));

        return $trx_id;
    }

    /**
     * Normalize user phone number into local Indonesian format starting with 0.
     * Examples:
     *  - "+62 813-8780-7580" => "081387807580"
     *  - "0813 878 07580" => "081387807580"
     *  - "81387807580" => "081387807580"
     *
     * @param string|null $phone
     * @return string
     */
    public function sanitizePhoneNumber($phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if ($digits === '') {
            return '';
        }

        // If starts with country code 62, convert to leading 0
        if (strpos($digits, '62') === 0) {
            $digits = '0' . substr($digits, 2);
        } elseif (strpos($digits, '0') === 0) {
            // already local format
        } elseif (strpos($digits, '8') === 0) {
            // missing leading zero
            $digits = '0' . $digits;
        }

        // Collapse multiple leading zeros into a single leading zero
        $digits = preg_replace('/^0+/', '0', $digits);

        return $digits;
    }

    public function generateVirtualAccountByCustomerPhone($customerPhone)
    {
        $mode = $this->mode;
        $prefix_va = $mode != 'production' ? 988 : 8;
        $client_id = $mode != 'production' ? 16012 : 900;

        // In dev we keep existing behavior: random 8 digits
        if ($mode != 'production') {
            $random = rand(pow(10, 8-1), pow(10, 8)-1);
            return $prefix_va . $client_id . str_pad($random, 8, '0', STR_PAD_LEFT);
        }

        // normalize phone first
        $sanitized = $this->sanitizePhoneNumber($customerPhone);

        // take last 12 digits to match legacy length and pad left if needed
        $digits = substr($sanitized, -12);
        $virtual_account = $prefix_va . $client_id . str_pad($digits, 12, '0', STR_PAD_LEFT);

        return $virtual_account;
    }
    
    public function createPayment(array $data)
    {
        $handler = $this->getHandler($data['method'] ?? 'BBNI');

        if (!$handler) {
            throw new Exception('Payment method not supported: ' . ($data['method'] ?? 'NULL'));
        }

        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
        ];

        try {
            $data['customer_phone'] = $this->sanitizePhoneNumber($data['customer_phone'] ?? null);
            $methodKey = $handler->getKey();
            $trxId = $this->generateTrxId($methodKey, $data['type'] ?? '999');
            $payload = $handler->buildPayload($data, $data['trx_id'] ?? $trxId);

            // use global helper postCurl (app/Helpers/Curl.php)
            $response = postCurl($handler->getUrl(), $payload, $headers);

            return is_object($response) ? (array) $response : ($response ?? []);
        } catch (Exception $ex) {
            // in case of error, return empty array or rethrow depending on needs
            return [];
        }
    }

    public function updatePayment(array $data)
    {
        $handler = $this->getHandler($data['method'] ?? null);

        if (!$handler) {
            throw new Exception('Payment method not supported: ' . ($data['method'] ?? 'NULL'));
        }

        $trxId = $data['trx_id'] ?? $data['trxId'] ?? null;
        if (!$trxId) {
            throw new Exception('Missing trx_id for updatePayment');
        }

        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
        ];

        // Allow caller to pass a custom payload (e.g. only fields to update)
        $payload = $data['payload'] ?? $handler->buildPayload($data, $trxId);

        try {
            $url = rtrim($handler->getUrl(), '/') . '/' . $trxId;
            $response = putCurl($url, $payload, $headers);

            return is_object($response) ? (array) $response : ($response ?? []);
        } catch (Exception $ex) {
            return [];
        }
    }
}