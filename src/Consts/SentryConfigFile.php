<?php

declare(strict_types=1);

namespace Extalion\Sentry\Consts;

final class SentryConfigFile
{
    final public function __construct()
    {
    }

    public static function getPath(): string
    {
        $path = \realpath(__DIR__ . '/../..');
        $path .= '/sentry.json';

        return $path;
    }
}
