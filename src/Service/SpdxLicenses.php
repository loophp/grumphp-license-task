<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Service;

use Composer\Spdx\SpdxLicenses as ComposerSpdxLicenses;

final class SpdxLicenses implements SpdxLicensesInterface
{
    private ComposerSpdxLicenses $spdxLicenses;

    public function __construct(ComposerSpdxLicenses $spdxLicenses)
    {
        $this->spdxLicenses = $spdxLicenses;
    }

    public function validate(string $license): bool
    {
        return $this->spdxLicenses->validate($license);
    }
}
