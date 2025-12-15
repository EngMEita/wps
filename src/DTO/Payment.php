<?php

namespace Meita\Wps\DTO;

class Payment
{
    public function __construct(
        public readonly string $employeeId,
        public readonly string $employeeName,
        public readonly string $nationalId,
        public readonly string $iban,
        public readonly float $amount,
        public readonly string $currency = 'SAR',
        public readonly ?string $notes = null
    ) {
    }
}
