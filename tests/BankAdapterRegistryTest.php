<?php

namespace Meita\Wps\Tests;

use Meita\Wps\BankAdapterRegistry;
use Meita\Wps\Tests\Support\FakeDelimitedAdapter;
use PHPUnit\Framework\TestCase;

class BankAdapterRegistryTest extends TestCase
{
    public function test_get_returns_registered_adapter(): void
    {
        $adapter = new FakeDelimitedAdapter();
        $registry = new BankAdapterRegistry([$adapter->key() => $adapter]);

        $resolved = $registry->get('fake');

        $this->assertSame($adapter, $resolved);
        $this->assertArrayHasKey('fake', $registry->all());
    }

    public function test_add_registers_adapter(): void
    {
        $adapter = new FakeDelimitedAdapter();
        $registry = new BankAdapterRegistry();

        $registry->add($adapter);

        $this->assertSame($adapter, $registry->get('fake'));
    }

    public function test_get_throws_for_unknown_adapter(): void
    {
        $registry = new BankAdapterRegistry();

        $this->expectException(\InvalidArgumentException::class);
        $registry->get('missing');
    }
}
