<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Service;

interface SpdxLicensesInterface
{
    public function validate(string $license): bool;
}
