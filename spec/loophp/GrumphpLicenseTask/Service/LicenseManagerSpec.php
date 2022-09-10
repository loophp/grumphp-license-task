<?php

declare(strict_types=1);

namespace spec\loophp\GrumphpLicenseTask\Service;

use Exception;
use GrumPHP\Util\Paths;
use loophp\GrumphpLicenseTask\Entity\LicenseInterface;
use loophp\GrumphpLicenseTask\Service\LicenseManager;
use loophp\GrumphpLicenseTask\Service\SpdxLicensesInterface;
use PhpSpec\ObjectBehavior;

use function dirname;

class LicenseManagerSpec extends ObjectBehavior
{
    public function it_can_get_a_license_from_a_file()
    {
        $licenseContent = 'Foobar license';
        $filepath = tempnam(dirname(__DIR__, 4) . '/build', 'test-');

        file_put_contents($filepath, $licenseContent);

        $this
            ->getLicenseFromFile(basename($filepath), 'name', '2000')
            ->shouldReturnAnInstanceOf(LicenseInterface::class);
    }

    public function it_can_get_a_license_from_its_name()
    {
        $this
            ->getLicenseFromName('MIT', 'name', '2000')
            ->shouldReturnAnInstanceOf(LicenseInterface::class);
    }

    public function it_can_get_available_licenses()
    {
        $this
            ->getAvailableLicenses()
            ->shouldReturn(
                [
                    'AGPL-3.0',
                    'BSD-3-Clause',
                    'EUPL-1.2',
                    'LGPL-2.0',
                    'LGPL-2.1',
                    'LGPL-3.0',
                    'MIT',
                ]
            );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LicenseManager::class);
    }

    public function it_throws_an_error_if_license_is_found()
    {
        $this
            ->shouldThrow(Exception::class)
            ->during('getLicenseFromName', ['ValidOsiLicense', 'name', '2000']);
    }

    public function it_throws_an_error_if_license_is_not_osi()
    {
        $this
            ->shouldThrow(Exception::class)
            ->during('getLicenseFromName', ['InvalidOsiLicense', 'name', '2000']);
    }

    public function let(SpdxLicensesInterface $spdxLicenses, Paths $paths)
    {
        $this->beConstructedWith($spdxLicenses, $paths);

        $spdxLicenses
            ->validate('MIT')
            ->willReturn(true);

        $spdxLicenses
            ->validate('InvalidOsiLicense')
            ->willReturn(false);

        $spdxLicenses
            ->validate('ValidOsiLicense')
            ->willReturn(true);

        $paths
            ->getProjectDir()
            ->willReturn(dirname(__DIR__, 4) . '/build');
    }
}
