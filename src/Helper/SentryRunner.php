<?php

declare(strict_types=1);

namespace Extalion\Sentry\Helper;

use Extalion\Sentry\Consts\ErrorTypesRegex;
use Extalion\Sentry\Consts\SentryConfigFile;

class SentryRunner
{
    public static function run(): void
    {
        $config = self::getConfigFromFile();

        \Sentry\init($config);
    }

    private static function getConfigFromFile(): array
    {
        $configContent = '';
        $configFile = SentryConfigFile::getPath();

        if (\file_exists($configFile)) {
            $configContent = \file_get_contents($configFile);
        }

        $config = (array) \json_decode($configContent, true);
        $errorTypes = self::validErrorTypes($config['error_types'] ?? '');
        $config['error_types'] = eval("return {$errorTypes};");
        $config['sample_rate'] = (float) ($config['sample_rate'] ?? 1);
        $config['environment'] = $config['environment'] ?? null;

        return $config;
    }

    private static function validErrorTypes(string $errorTypes): string
    {
        if (!$errorTypes) {
            return '';
        }

        $output = [];
        \preg_match('/' . ErrorTypesRegex::REGEX . '/', $errorTypes, $output);

        if ($output && $output[0] === $errorTypes) {
            return $errorTypes;
        }

        return '';
    }
}
