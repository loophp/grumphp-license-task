<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Entity;

use Ergebnis\License\File;
use Ergebnis\License\Holder;
use Ergebnis\License\Period;
use Ergebnis\License\Template;

interface LicenseInterface
{
    public function __toString(): string;

    public function getHolder(): Holder;

    public function getPeriod(): Period;

    public function getTemplate(): Template;

    public function toFile(string $filepath): File;
}
