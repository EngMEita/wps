# Meita WPS

PHP/Laravel package that generates Saudi WPS payroll files with multi-bank support (Al Rajhi, Riyad, SNB AlAhli, Alinma, ANB). All classes live under the `Meita\Wps` namespace.

## Requirements
- PHP 8.1+
- Works in any PHP app or Laravel project.

## Installation
```bash
composer require meita/wps
```

## Quick start (PHP)
```php
use Meita\Wps\Adapters\{AlRajhiAdapter, RiyadAdapter, AlAhliAdapter, AlinmaAdapter, ArabNationalBankAdapter};
use Meita\Wps\BankAdapterRegistry;
use Meita\Wps\PayrollProtectionManager;
use Meita\Wps\DTO\{Payment, PaymentBatch};

$registry = new BankAdapterRegistry([
    'alrajhi' => new AlRajhiAdapter(),
    'riyad' => new RiyadAdapter(),
    'alahli' => new AlAhliAdapter(),
    'alinma' => new AlinmaAdapter(),
    'anb' => new ArabNationalBankAdapter(),
]);

$batch = new PaymentBatch(
    companyId: '1234567890',
    companyName: 'Meita LLC',
    payrollMonth: '2024-05',
    payments: [
        new Payment('EMP-1', 'Ali Saleh', '1010101010', 'SA123...', 5500.75),
        new Payment('EMP-2', 'Sara Ahmed', '2020202020', 'SA456...', 4300.00, notes: 'Commission included'),
    ],
    reference: 'MAY-24',
    contactEmail: 'payroll@meita.sa'
);

$manager = new PayrollProtectionManager($registry);
$file = $manager->generate('alrajhi', $batch);
file_put_contents($file->filename, $file->content);
```

## Laravel usage
- The service provider auto-registers the default adapters and binds `PayrollProtectionManager`.
- Example:
```php
use Meita\Wps\PayrollProtectionManager;
use Meita\Wps\DTO\{Payment, PaymentBatch};

$batch = /* build your PaymentBatch */;
$file = app(PayrollProtectionManager::class)->generate('riyad', $batch);
Storage::put(\"wps/{$file->filename}\", $file->content);
```
- To override or add adapters, bind your own `BankAdapterRegistry` in a service provider before resolving `PayrollProtectionManager`.

## Adding a custom bank adapter
1. Extend `Meita\Wps\Adapters\AbstractDelimitedAdapter`.
2. Implement `key()`, `bankName()`, `header()` (optional), and `fields()` to shape each row.
3. Register the adapter in `BankAdapterRegistry` (either manually or via a Laravel service provider).

## Supported adapters
- `alrajhi`
- `riyad`
- `alahli` (SNB)
- `alinma`
- `anb`
