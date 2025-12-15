<?php

namespace Meita\Wps\Adapters;

use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

class RiyadAdapter extends AbstractDelimitedAdapter
{
    protected string $delimiter = '|';

    public function key(): string
    {
        return 'riyad';
    }

    public function bankName(): string
    {
        return 'Riyad Bank';
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return implode($this->delimiter, [
            'company',
            'employee',
            'iban',
            'amount',
            'currency',
            'payroll_month',
            'contact_email',
        ]);
    }

    protected function fields(Payment $payment, PaymentBatch $batch): array
    {
        return [
            "{$batch->companyId}-{$batch->companyName}",
            "{$payment->employeeId}-{$payment->employeeName}",
            $payment->iban,
            number_format($payment->amount, 2, '.', ''),
            $payment->currency,
            $batch->payrollMonth,
            $batch->contactEmail,
        ];
    }
}
