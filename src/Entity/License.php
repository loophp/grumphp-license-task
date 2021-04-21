<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Entity;

use Ergebnis\License\File;
use Ergebnis\License\Holder;
use Ergebnis\License\Period;
use Ergebnis\License\Template;
use Exception;

final class License implements LicenseInterface
{
    private Holder $holder;

    private Period $period;

    private Template $template;

    public function __construct(
        Template $fileTemplate,
        Period $period,
        Holder $holder
    ) {
        $this->template = $fileTemplate;
        $this->period = $period;
        $this->holder = $holder;
    }

    public function __toString(): string
    {
        $file = tmpfile();

        if (false === $file) {
            throw new Exception('Unable to generate temporary tmp file.');
        }

        $path = stream_get_meta_data($file)['uri'];

        $this->toFile($path)->save();

        return (string) file_get_contents($path);
    }

    public function getHolder(): Holder
    {
        return $this->holder;
    }

    public function getPeriod(): Period
    {
        return $this->period;
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }

    public function toFile(string $filepath): File
    {
        return File::create(
            $filepath,
            $this->template,
            $this->period,
            $this->holder
        );
    }
}
