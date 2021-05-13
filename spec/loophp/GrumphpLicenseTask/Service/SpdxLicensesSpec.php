<?php

declare(strict_types=1);

namespace spec\loophp\GrumphpLicenseTask\Service;

use Composer\Spdx\SpdxLicenses as ComposerSpdxLicenses;
use loophp\GrumphpLicenseTask\Service\SpdxLicenses;
use PhpSpec\ObjectBehavior;

class SpdxLicensesSpec extends ObjectBehavior
{
    public function it_can_validate_a_license()
    {
        $this
            ->validate('MIT')
            ->shouldReturn(true);

        $this
            ->validate('MUT')
            ->shouldReturn(false);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SpdxLicenses::class);
    }

    public function let(ComposerSpdxLicenses $spdxLicenses)
    {
        $this->beConstructedWith($spdxLicenses);

        $spdxLicenses
            ->validate('MIT')
            ->willReturn(true);

        $spdxLicenses
            ->validate('MUT')
            ->willReturn(false);
    }
}
