<?php

namespace Meita\Wps;

use Meita\Wps\Contracts\BankFile;
use Meita\Wps\DTO\PaymentBatch;

class PayrollProtectionManager
{
    public function __construct(private readonly BankAdapterRegistry $registry)
    {
    }

    public function generate(string $bankKey, PaymentBatch $batch): BankFile
    {
        $adapter = $this->registry->get($bankKey);

        return $adapter->makeFile($batch);
    }
}
