<?php

namespace Meita\Wps\Adapters;

use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

class AlinmaAdapter extends AbstractDelimitedAdapter
{
    protected string $delimiter = "\t";

    public function key(): string
    {
        return 'alinma';
    }

    public function bankName(): string
    {
        return 'Alinma Bank';
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return implode($this->delimiter, [
            'company',
            'employee_id',
            'national_id',
            'iban',
            'amount',
            'currency',
            'month',
        ]);
    }

    protected function fields(Payment $payment, PaymentBatch $batch): array
    {
        return [
            $batch->companyName,
            $payment->employeeId,
            $payment->nationalId,
            $payment->iban,
            number_format($payment->amount, 2, '.', ''),
            $payment->currency,
            $batch->payrollMonth,
        ];
    }
}
