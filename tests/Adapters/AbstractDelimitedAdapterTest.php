<?php

namespace Meita\Wps\Tests\Adapters;

use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;
use Meita\Wps\Tests\Support\FakeDelimitedAdapter;
use PHPUnit\Framework\TestCase;

class AbstractDelimitedAdapterTest extends TestCase
{
    public function test_make_file_builds_csv_with_expected_delimiter_and_line_endings(): void
    {
        $adapter = new FakeDelimitedAdapter();
        $batch = new PaymentBatch(
            companyId: '123',
            companyName: 'Acme',
            payrollMonth: '2024-05',
            payments: [
                new Payment('EMP-1', 'Alice', '1010101010', 'SA123456', 1000.5),
            ],
            reference: 'REF'
        );

        $file = $adapter->makeFile($batch);

        $this->assertSame("employee_id\r\nEMP-1\r\n", $file->content);
        $this->assertSame('fake_123_REF.csv', $file->filename);
    }

    public function test_make_file_rejects_invalid_iban(): void
    {
        $adapter = new FakeDelimitedAdapter();
        $batch = new PaymentBatch(
            companyId: '123',
            companyName: 'Acme',
            payrollMonth: '2024-05',
            payments: [
                new Payment('EMP-1', 'Alice', '1010101010', 'XX123456', 1000.5),
            ]
        );

        $this->expectException(\InvalidArgumentException::class);
        $adapter->makeFile($batch);
    }

    public function test_make_file_rejects_non_positive_amounts(): void
    {
        $adapter = new FakeDelimitedAdapter();
        $batch = new PaymentBatch(
            companyId: '123',
            companyName: 'Acme',
            payrollMonth: '2024-05',
            payments: [
                new Payment('EMP-1', 'Alice', '1010101010', 'SA123456', 0),
            ]
        );

        $this->expectException(\InvalidArgumentException::class);
        $adapter->makeFile($batch);
    }
}
