<?php

namespace App\Services\Payments;

use App\Services\UperpayService;

class BniPaymentMethod implements PaymentMethodInterface
{
    protected UperpayService $service;

    public function __construct(UperpayService $service)
    {
        $this->service = $service;
    }

    public function getKey(): string
    {
        return 'BBNI';
    }

    public function getUrl(): string
    {
        return $this->service->getBniUrl();
    }

    public function buildPayload(array $data, string $trxId): array
    {
        $payload = [
            'trx_id' => $trxId,
            'customer_name' => $data['customer_name'] ?? null,
            'customer_email' => $data['customer_email'] ?? null,
            'customer_phone' => $data['customer_phone'] ?? null,
            'trx_amount' => $data['trx_amount'] ?? 0,
            'datetime_expired' => $data['datetime_expired'] ?? null,
            'description' => $data['description'] ?? '',
        ];

        if ($data['virtual_account'] ?? false) {
            $payload['virtual_account'] = $data['virtual_account'];
        }

        return $payload;
    }
}
