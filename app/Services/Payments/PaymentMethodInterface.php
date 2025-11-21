<?php

namespace App\Services\Payments;

interface PaymentMethodInterface
{
    public function getKey(): string;

    public function getUrl(): string;

    /**
     * Build the payload for this payment method. Caller is responsible to create trx id.
     *
     * @param array $data
     * @param string $trxId
     * @return array
     */
    public function buildPayload(array $data, string $trxId): array;
}
