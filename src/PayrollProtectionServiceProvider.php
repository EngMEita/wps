<?php

namespace Meita\Wps;

use Illuminate\Support\ServiceProvider;
use Meita\Wps\Adapters\AlAhliAdapter;
use Meita\Wps\Adapters\AlinmaAdapter;
use Meita\Wps\Adapters\AlRajhiAdapter;
use Meita\Wps\Adapters\ArabNationalBankAdapter;
use Meita\Wps\Adapters\RiyadAdapter;

class PayrollProtectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BankAdapterRegistry::class, function () {
            $registry = new BankAdapterRegistry();
            $registry->add(new AlRajhiAdapter());
            $registry->add(new RiyadAdapter());
            $registry->add(new AlAhliAdapter());
            $registry->add(new AlinmaAdapter());
            $registry->add(new ArabNationalBankAdapter());

            return $registry;
        });

        $this->app->singleton(PayrollProtectionManager::class, function ($app) {
            return new PayrollProtectionManager($app->make(BankAdapterRegistry::class));
        });
    }
}
