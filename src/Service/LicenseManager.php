<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Service;

use DateTimeZone;
use Ergebnis\License\Holder;
use Ergebnis\License\Range;
use Ergebnis\License\Template;
use Ergebnis\License\Year;
use Exception;
use GrumPHP\Util\Paths;
use loophp\GrumphpLicenseTask\Entity\License;
use loophp\GrumphpLicenseTask\Entity\LicenseInterface;

use function in_array;

use const PATHINFO_FILENAME;

final class LicenseManager implements LicenseManagerInterface
{
    private Paths $paths;

    private SpdxLicensesInterface $spdxLicenses;

    public function __construct(SpdxLicensesInterface $spdxLicenses, Paths $paths)
    {
        $this->paths = $paths;
        $this->spdxLicenses = $spdxLicenses;
    }

    public function getAvailableLicenses(): array
    {
        $glob = glob(__DIR__ . '/../../resource/licenses/*.txt');

        if (false === $glob) {
            return [];
        }

        return array_map(
            static fn (string $filename): string => pathinfo($filename, PATHINFO_FILENAME),
            $glob
        );
    }

    public function getLicenseFromFile(string $filename, string $holder, int $fromYear): LicenseInterface
    {
        return new License(
            Template::fromFile(sprintf('%s/%s', $this->paths->getProjectDir(), $filename)),
            Range::since(
                Year::fromString((string) $fromYear),
                new DateTimeZone('UTC')
            ),
            Holder::fromString($holder)
        );
    }

    public function getLicenseFromName(string $osiName, string $holder, ?int $fromYear): LicenseInterface
    {
        if (false === $this->spdxLicenses->validate($osiName)) {
            throw new Exception('License is not a valid OSI license.');
        }

        if (false === in_array(strtolower($osiName), array_map('strtolower', $this->getAvailableLicenses()), true)) {
            throw new Exception(
                'License is valid but does not exist yet in loophp/grumphp-license-task. Submit a PR !'
            );
        }

        $fromYear ??= date('Y');

        return new License(
            Template::fromFile(sprintf('%s%s.txt', __DIR__ . '/../../resource/licenses/', $osiName)),
            Range::since(
                Year::fromString((string) $fromYear),
                new DateTimeZone('UTC')
            ),
            Holder::fromString($holder)
        );
    }
}
