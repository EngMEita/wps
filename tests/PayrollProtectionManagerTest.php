<?php

namespace Meita\Wps\Tests;

use Meita\Wps\BankAdapterRegistry;
use Meita\Wps\DTO\Payment;
use Meita\Wps\DTO\PaymentBatch;
use Meita\Wps\PayrollProtectionManager;
use Meita\Wps\Tests\Support\FakeDelimitedAdapter;
use PHPUnit\Framework\TestCase;

class PayrollProtectionManagerTest extends TestCase
{
    public function test_generate_delegates_to_adapter_and_returns_bank_file(): void
    {
        $adapter = new FakeDelimitedAdapter();
        $registry = new BankAdapterRegistry();
        $registry->add($adapter);

        $batch = new PaymentBatch(
            companyId: '1234567890',
            companyName: 'Meita LLC',
            payrollMonth: '2024-05',
            payments: [
                new Payment('EMP-1', 'Alice', '1010101010', 'SA1234567890', 2500.00),
            ],
            reference: 'REF-1'
        );

        $manager = new PayrollProtectionManager($registry);
        $file = $manager->generate('fake', $batch);

        $this->assertSame('fake_1234567890_REF-1.csv', $file->filename);
        $this->assertStringContainsString('EMP-1', $file->content);
        $this->assertSame('text/csv', $file->mimeType);
    }
}
