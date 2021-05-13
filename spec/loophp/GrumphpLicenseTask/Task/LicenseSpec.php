<?php

declare(strict_types=1);

namespace spec\loophp\GrumphpLicenseTask\Task;

use GrumPHP\Util\Paths;
use loophp\GrumphpLicenseTask\Service\LicenseManagerInterface;
use loophp\GrumphpLicenseTask\Task\License;
use PhpSpec\ObjectBehavior;

final class LicenseSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(License::class);
    }

    public function let(LicenseManagerInterface $licenseManager, Paths $paths)
    {
        $this->beConstructedWith($licenseManager, $paths);
    }
}
