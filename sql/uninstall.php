<?php

$dbPrefix = _DB_PREFIX_;
$moduleName = \basename(\dirname(__DIR__));
$sql = [];

foreach ($sql as $query) {
    if (!Db::getInstance()->execute($query)) {
        return false;
    }
}

return true;
