<?php

namespace Meita\Wps\Contracts;

use Meita\Wps\DTO\PaymentBatch;

interface BankAdapter
{
    public function key(): string;

    public function bankName(): string;

    public function makeFile(PaymentBatch $batch): BankFile;

    /**
     * @throws \InvalidArgumentException
     */
    public function validate(PaymentBatch $batch): void;
}
