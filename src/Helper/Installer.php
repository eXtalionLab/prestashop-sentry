<?php

declare(strict_types=1);

namespace Extalion\Sentry\Helper;

use Extalion\Sentry\Exception\InstallerException;

class Installer
{
    public static function enableSentry(): void
    {
        $customDefinesFile = self::getCustomDefinesFile();

        if (!\file_exists($customDefinesFile)) {
            self::createFile($customDefinesFile);
        }

        $customDefinesFileContent = self::getFileContent($customDefinesFile);
        $sentryEntry = self::getSentryEntry();

        if (self::isSentryInstalled($customDefinesFileContent, $sentryEntry)) {
            return;
        }

        $customDefinesFileContent = <<<TXT
            $customDefinesFileContent

            $sentryEntry
            TXT
        ;

        self::putFileContent($customDefinesFile, $customDefinesFileContent);
    }

    public static function disableSentry(): void
    {
        $customDefinesFile = self::getCustomDefinesFile();

        if (!\file_exists($customDefinesFile)) {
            return;
        }

        $customDefinesFileContent = self::getFileContent($customDefinesFile);
        $sentryEntry = self::getSentryEntry();

        if (!self::isSentryInstalled($customDefinesFileContent, $sentryEntry)) {
            return;
        }

        $customDefinesFileContent = \str_replace(
            $sentryEntry,
            '',
            $customDefinesFileContent
        );

        self::putFileContent($customDefinesFile, $customDefinesFileContent);
    }

    private static function createFile(string $file): void
    {
        $parent = \dirname($file);

        if (!\is_writable($parent)) {
            throw new InstallerException("Parent dir \"{$parent}\" is not writable!");
        }

        if (!\touch($file)) {
            throw new InstallerException("Could not create file \"{$file}\"!");
        }
    }

    private static function getCustomDefinesFile(): string
    {
        $rootDir = self::getRootDir();

        return "{$rootDir}/config/defines_custom.inc.php";
    }

    private static function getFileContent(string $file): string
    {
        if (!\is_readable($file)) {
            throw new InstallerException("File \"{$file}\" is not readable!");
        }

        return \file_get_contents($file);
    }

    private static function getRootDir(): string
    {
        return \realpath(__DIR__ . '/../../../../');
    }

    private static function getSentryEntry(): string
    {
        $rootDir = self::getRootDir();

        return <<<TXT
        ###> extsentry ###
        require_once "{$rootDir}/config/defines.inc.php";
        require_once _PS_CONFIG_DIR_ . 'autoload.php';
        require_once "{$rootDir}/modules/extsentry/vendor/autoload.php";

        \Extalion\Sentry\Helper\SentryRunner::run();
        ###< extsentry ###
        TXT;
    }

    private static function isSentryInstalled(
        string $fileContent,
        string $sentryEntry
    ): bool {
        return \strpos($fileContent, \trim($sentryEntry)) !== false;
    }

    private static function putFileContent(string $file, string $content): void
    {
        if (!\is_writable($file)) {
            throw new InstallerException("File \"{$file}\" is not writable!");
        }

        if (\file_put_contents($file, \trim($content)) === false) {
            throw new InstallerException("Could not save content to file \"{$file}\".");
        }
    }
}
