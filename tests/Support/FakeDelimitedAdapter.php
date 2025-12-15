<?php

namespace Meita\Wps\Tests\Support;

use Meita\Wps\Adapters\AbstractDelimitedAdapter;
use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

class FakeDelimitedAdapter extends AbstractDelimitedAdapter
{
    public function key(): string
    {
        return 'fake';
    }

    public function bankName(): string
    {
        return 'Fake Bank';
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return 'employee_id';
    }

    protected function fields(Payment $payment, PaymentBatch $batch): array
    {
        return [$payment->employeeId];
    }
}
