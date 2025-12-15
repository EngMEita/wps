<?php

namespace Meita\Wps\DTO;

class PaymentBatch
{
    /**
     * @param Payment[] $payments
     */
    public function __construct(
        public readonly string $companyId,
        public readonly string $companyName,
        public readonly string $payrollMonth, // YYYY-MM
        public readonly array $payments,
        public readonly ?string $reference = null,
        public readonly ?string $contactEmail = null
    ) {
    }
}
