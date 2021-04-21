<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask;

use Composer\Spdx\SpdxLicenses as ComposerSpdxLicenses;
use GrumPHP\Extension\ExtensionInterface;
use loophp\GrumphpLicenseTask\Service\LicenseManager;
use loophp\GrumphpLicenseTask\Service\SpdxLicenses;
use loophp\GrumphpLicenseTask\Task\License;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class Extension implements ExtensionInterface
{
    public function load(ContainerBuilder $container): void
    {
        $container
            ->register('loophp.grumphp_license_task.spdx_licenses', SpdxLicenses::class)
            ->addArgument(new ComposerSpdxLicenses());

        $container
            ->register('loophp.grumphp_license_task.license_manager', LicenseManager::class)
            ->addArgument(new Reference('loophp.grumphp_license_task.spdx_licenses'));

        $container
            ->register('task.license', License::class)
            ->addArgument(new Reference('loophp.grumphp_license_task.license_manager'))
            ->addArgument(new Reference('GrumPHP\Util\Paths'))
            ->addTag('grumphp.task', ['task' => 'license']);
    }
}
