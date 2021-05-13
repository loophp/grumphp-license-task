<?php

declare(strict_types=1);

namespace spec\loophp\GrumphpLicenseTask\Entity;

use Ergebnis\License\File;
use Ergebnis\License\Holder;
use Ergebnis\License\Period;
use Ergebnis\License\Range;
use Ergebnis\License\Template;
use Ergebnis\License\Year;
use loophp\GrumphpLicenseTask\Entity\License;
use PhpSpec\ObjectBehavior;

class LicenseSpec extends ObjectBehavior
{
    public function it_can_get_the_holder()
    {
        $this
            ->getHolder()
            ->shouldReturnAnInstanceOf(Holder::class);
    }

    public function it_can_get_the_period()
    {
        $this
            ->getPeriod()
            ->shouldReturnAnInstanceOf(Period::class);
    }

    public function it_can_get_the_template()
    {
        $this
            ->getTemplate()
            ->shouldReturnAnInstanceOf(Template::class);
    }

    public function it_convert_the_license_to_a_file()
    {
        $licenseContent = 'Foobar license';
        $filepath = tempnam(sys_get_temp_dir(), 'test-');

        file_put_contents($filepath, $licenseContent);

        $this
            ->toFile($filepath)
            ->shouldReturnAnInstanceOf(File::class);
    }

    public function it_convert_the_license_to_a_string()
    {
        $licenseContent = 'Foobar license';
        $filepath = tempnam(sys_get_temp_dir(), 'test-');

        file_put_contents($filepath, $licenseContent);

        $this
            ->__toString()
            ->shouldReturn('Foobar foobar 2000-2020');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(License::class);
    }

    public function let()
    {
        $template = Template::fromString('Foobar <holder> <range>');
        $period = Range::including(Year::fromString('2000'), Year::fromString('2020'));
        $holder = Holder::fromString('foobar');

        $this->beConstructedWith($template, $period, $holder);
    }
}
