<?php

namespace Meita\Wps\Adapters;

use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

class AlRajhiAdapter extends AbstractDelimitedAdapter
{
    protected string $delimiter = ';';

    public function key(): string
    {
        return 'alrajhi';
    }

    public function bankName(): string
    {
        return 'Al Rajhi Bank';
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return implode($this->delimiter, [
            'company_id',
            'employee_id',
            'national_id',
            'iban',
            'amount',
            'currency',
            'payroll_month',
            'notes',
        ]);
    }

    protected function fields(Payment $payment, PaymentBatch $batch): array
    {
        return [
            $batch->companyId,
            $payment->employeeId,
            $payment->nationalId,
            $payment->iban,
            number_format($payment->amount, 2, '.', ''),
            $payment->currency,
            $batch->payrollMonth,
            $payment->notes,
        ];
    }
}
