<?php

namespace Meita\Wps\Adapters;

use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

class AlAhliAdapter extends AbstractDelimitedAdapter
{
    protected string $delimiter = ',';

    public function key(): string
    {
        return 'alahli';
    }

    public function bankName(): string
    {
        return 'SNB AlAhli';
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return implode($this->delimiter, [
            'company_id',
            'employee_id',
            'name',
            'iban',
            'amount',
            'payroll_month',
            'reference',
        ]);
    }

    protected function fields(Payment $payment, PaymentBatch $batch): array
    {
        return [
            $batch->companyId,
            $payment->employeeId,
            $payment->employeeName,
            $payment->iban,
            number_format($payment->amount, 2, '.', ''),
            $batch->payrollMonth,
            $batch->reference,
        ];
    }
}
