<?php

namespace Meita\Wps\Adapters;

use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

class ArabNationalBankAdapter extends AbstractDelimitedAdapter
{
    protected string $delimiter = ',';

    public function key(): string
    {
        return 'anb';
    }

    public function bankName(): string
    {
        return 'Arab National Bank';
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return implode($this->delimiter, [
            'company_id',
            'employee_id',
            'iban',
            'amount',
            'month',
            'note',
        ]);
    }

    protected function fields(Payment $payment, PaymentBatch $batch): array
    {
        return [
            $batch->companyId,
            $payment->employeeId,
            $payment->iban,
            number_format($payment->amount, 2, '.', ''),
            $batch->payrollMonth,
            $payment->notes,
        ];
    }
}
