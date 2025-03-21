<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask;

use GrumPHP\Extension\ExtensionInterface;

final class Extension implements ExtensionInterface
{
    public function imports(): iterable
    {
        yield __DIR__ . '/services.yaml';
    }
}
