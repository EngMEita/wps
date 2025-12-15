<?php

namespace Meita\Wps\Adapters;

use Meita\Wps\Contracts\BankAdapter;
use Meita\Wps\Contracts\BankFile;
use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;

abstract class AbstractDelimitedAdapter implements BankAdapter
{
    protected string $delimiter = ',';
    protected string $lineEnding = "\r\n";
    protected string $dateFormat = 'Y-m-d';

    public function makeFile(PaymentBatch $batch): BankFile
    {
        $this->validate($batch);

        $rows = [];
        $header = $this->header($batch);
        if ($header) {
            $rows[] = $header;
        }

        foreach ($batch->payments as $payment) {
            $rows[] = $this->mapRow($payment, $batch);
        }

        $content = implode($this->lineEnding, $rows) . $this->lineEnding;

        return new BankFile(
            filename: $this->filename($batch),
            content: $content,
            mimeType: 'text/csv'
        );
    }

    public function validate(PaymentBatch $batch): void
    {
        foreach ($batch->payments as $payment) {
            if (!$payment instanceof Payment) {
                throw new \InvalidArgumentException('All payments must be Payment DTO instances.');
            }

            if (!str_starts_with(strtoupper($payment->iban), 'SA')) {
                throw new \InvalidArgumentException("IBAN for {$payment->employeeId} must start with SA.");
            }

            if ($payment->amount <= 0) {
                throw new \InvalidArgumentException("Amount for {$payment->employeeId} must be greater than zero.");
            }
        }
    }

    protected function filename(PaymentBatch $batch): string
    {
        $ref = $batch->reference ?: date('YmdHis');

        return strtolower($this->key() . "_{$batch->companyId}_{$ref}.csv");
    }

    protected function header(PaymentBatch $batch): ?string
    {
        return implode($this->delimiter, [
            'company_id',
            'company_name',
            'payroll_month',
            'generated_at',
        ]);
    }

    protected function mapRow(Payment $payment, PaymentBatch $batch): string
    {
        return implode($this->delimiter, $this->fields($payment, $batch));
    }

    /**
     * @return array<string|int|float|null>
     */
    abstract protected function fields(Payment $payment, PaymentBatch $batch): array;
}
