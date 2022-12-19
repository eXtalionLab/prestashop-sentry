<?php

declare(strict_types=1);

function execute_sql(array $sqls): bool
{
    foreach ($sqls as $query) {
        if (!Db::getInstance()->execute($query)) {
            return false;
        }
    }

    return true;
}

function remove_files(array $files): bool
{
    foreach ($files as $file) {
        if (\file_exists($file) && !\unlink($file)) {
            return false;
        }
    }

    return true;
}
