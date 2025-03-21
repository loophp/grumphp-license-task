<?php

declare(strict_types=1);

namespace loophp\GrumphpLicenseTask\Task;

use Exception;
use GrumPHP\Fixer\FixResult;
use GrumPHP\Runner\FixableTaskResult;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\Config\ConfigOptionsResolver;
use GrumPHP\Task\Config\TaskConfigInterface;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use GrumPHP\Task\TaskInterface;
use GrumPHP\Util\Paths;
use loophp\GrumphpLicenseTask\Service\LicenseManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function sprintf;

final class License implements TaskInterface
{
    private TaskConfigInterface $config;

    private LicenseManagerInterface $licenseManager;

    private Paths $paths;

    public function __construct(LicenseManagerInterface $licenseManager, Paths $paths)
    {
        $this->licenseManager = $licenseManager;
        $this->paths = $paths;
    }

    public function canRunInContext(ContextInterface $context): bool
    {
        return $context instanceof GitPreCommitContext || $context instanceof RunContext;
    }

    public function getConfig(): TaskConfigInterface
    {
        return $this->config;
    }

    public static function getConfigurableOptions(): ConfigOptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults([
            'name' => null,
            'input' => null,
            'output' => 'LICENSE.txt',
            'date_from' => null,
            'holder' => null,
        ]);

        $resolver->addAllowedTypes('name', ['null', 'string']);
        $resolver->addAllowedTypes('input', ['null', 'string']);
        $resolver->addAllowedTypes('output', ['string']);
        $resolver->addAllowedTypes('date_from', ['null', 'int']);
        $resolver->addAllowedTypes('holder', ['null', 'string']);

        return ConfigOptionsResolver::fromOptionsResolver($resolver);
    }

    public function run(ContextInterface $context): TaskResultInterface
    {
        $config = $this->getConfig()->getOptions();

        if (null !== $config['name'] && null !== $config['input']) {
            throw new Exception('Both params cannot be set.');
        }

        if (null === $config['name'] && null !== $config['input']) {
            $license = $this->licenseManager->getLicenseFromFile(
                $config['input'],
                $config['holder'],
                $config['date_from']
            );
        } else {
            $license = $this->licenseManager->getLicenseFromName(
                $config['name'],
                $config['holder'],
                $config['date_from']
            );
        }

        $cwd = $this->paths->getProjectDir();

        $existing = file_exists(sprintf('%s/%s', $cwd, $config['output']));

        if (true === $existing) {
            $content = file_get_contents(sprintf('%s/%s', $cwd, $config['output']));

            if (false !== $content && (string) $license === $content) {
                return TaskResult::createPassed($this, $context);
            }
        }

        if (false === $existing) {
            $saveToFile = sprintf('%s/%s', $cwd, $config['output']);

            return new FixableTaskResult(
                TaskResult::createFailed($this, $context, 'The license file does not exist.'),
                static function () use ($license, $saveToFile): FixResult {
                    $license
                        ->toFile($saveToFile)
                        ->save();

                    return FixResult::success(TaskResultInterface::PASSED);
                }
            );
        }

        return new FixableTaskResult(
            TaskResult::createFailed($this, $context, 'The license file exists and is not valid.'),
            static function () use ($license, $cwd, $config): FixResult {
                $license
                    ->toFile(sprintf('%s/%s', $cwd, $config['output']))
                    ->save();

                return FixResult::success(TaskResultInterface::PASSED);
            }
        );
    }

    public function withConfig(TaskConfigInterface $config): TaskInterface
    {
        $new = clone $this;
        $new->config = $config;

        return $new;
    }
}
