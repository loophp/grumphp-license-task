<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Service;

use loophp\GrumphpLicenseTask\Entity\LicenseInterface;

interface LicenseManagerInterface
{
    /**
     * @psalm-return list<string>
     */
    public function getAvailableLicenses(): array;

    public function getLicenseFromFile(string $filename, string $holder, int $fromYear): LicenseInterface;

    public function getLicenseFromName(string $osiName, string $holder, int $fromYear): LicenseInterface;
}
