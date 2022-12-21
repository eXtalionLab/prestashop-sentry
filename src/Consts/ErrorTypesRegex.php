<?php

declare(strict_types=1);

namespace Extalion\Sentry\Consts;

final class ErrorTypesRegex
{
    public const REGEX = '^(~? *(E_[A-Z]+)+)([ &|^]+(~? *(E_[A-Z]+)+))*$';

    private function __construct()
    {
    }
}
