<?php

namespace Meita\Wps\Tests\Adapters;

use Meita\Wps\Adapters\AlRajhiAdapter;
use Meita\Wps\Adapters\RiyadAdapter;
use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;
use PHPUnit\Framework\TestCase;

class AdapterFormattingTest extends TestCase
{
    public function test_alrajhi_adapter_formats_expected_output(): void
    {
        $adapter = new AlRajhiAdapter();
        $batch = new PaymentBatch(
            companyId: '123',
            companyName: 'Meita LLC',
            payrollMonth: '2024-05',
            payments: [
                new Payment('EMP-1', 'Alice', '1010101010', 'SA123456789', 1000.5, notes: 'Bonus'),
            ]
        );

        $file = $adapter->makeFile($batch);

        $expected = 'company_id;employee_id;national_id;iban;amount;currency;payroll_month;notes'
            . "\r\n"
            . '123;EMP-1;1010101010;SA123456789;1000.50;SAR;2024-05;Bonus';

        $this->assertSame($expected . "\r\n", $file->content);
        $this->assertSame('text/csv', $file->mimeType);
    }

    public function test_riyad_adapter_formats_expected_output(): void
    {
        $adapter = new RiyadAdapter();
        $batch = new PaymentBatch(
            companyId: '123',
            companyName: 'Meita LLC',
            payrollMonth: '2024-05',
            payments: [
                new Payment('EMP-1', 'Alice', '1010101010', 'SA123456789', 7500.0),
            ],
            contactEmail: 'payroll@meita.sa'
        );

        $file = $adapter->makeFile($batch);

        $expected = 'company|employee|iban|amount|currency|payroll_month|contact_email'
            . "\r\n"
            . '123-Meita LLC|EMP-1-Alice|SA123456789|7500.00|SAR|2024-05|payroll@meita.sa';

        $this->assertSame($expected . "\r\n", $file->content);
    }
}
