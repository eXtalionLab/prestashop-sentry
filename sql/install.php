<?php

$dbPrefix = _DB_PREFIX_;
$sqlEngine = _MYSQL_ENGINE_;
$moduleName = \basename(\dirname(__DIR__));
$sql = [];

$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS {$dbPrefix}{$moduleName}_configuration (
        id_configuration INT AUTO_INCREMENT NOT NULL,
        name VARCHAR(255) NOT NULL,
        value LONGTEXT NOT NULL,
        PRIMARY KEY(id_configuration)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = {$sqlEngine};
SQL;

foreach ($sql as $query) {
    if (!Db::getInstance()->execute($query)) {
        return false;
    }
}

return true;
