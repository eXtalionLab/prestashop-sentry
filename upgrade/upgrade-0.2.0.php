<?php

declare(strict_types=1);

if (!\defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/upgrade.php';

function upgrade_module_0_2_0(ExtSentry $module): bool
{
    $dbPrefix = _DB_PREFIX_;
    $sqlEngine = _MYSQL_ENGINE_;
    $moduleDir = _PS_MODULE_DIR_;
    $sql = [];
    $files = [];

    $sql[] = <<<SQL
        ALTER TABLE `{$dbPrefix}{$module->name}`
            DROP COLUMN IF EXISTS `column_name`
    SQL;
    $files[] = "{$moduleDir}{$module->name}/module.file";

    return true
        // && $module->enable() // Reenable module allows to install new tab(s)
        // && $module->registerHook([])
        && execute_sql($sql)
        && remove_files($files)
    ;
}
