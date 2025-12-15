<?php

namespace Meita\Wps;

use Meita\Wps\Contracts\BankAdapter;

class BankAdapterRegistry
{
    /**
     * @param BankAdapter[] $adapters
     */
    public function __construct(private array $adapters = [])
    {
    }

    public function add(BankAdapter $adapter): void
    {
        $this->adapters[$adapter->key()] = $adapter;
    }

    /**
     * @return BankAdapter[]
     */
    public function all(): array
    {
        return $this->adapters;
    }

    public function get(string $key): BankAdapter
    {
        if (!isset($this->adapters[$key])) {
            throw new \InvalidArgumentException("Bank adapter [$key] is not registered.");
        }

        return $this->adapters[$key];
    }
}
