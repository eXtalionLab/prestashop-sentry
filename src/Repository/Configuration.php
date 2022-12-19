<?php

declare(strict_types=1);

namespace Extalion\Sentry\Repository;

use Doctrine\ORM\EntityRepository;

class Configuration extends EntityRepository
{
    public function get(string $name, $default = null)
    {
        $configuration = $this->findOneByName($name);

        return $configuration ? $configuration->getValue() : $default;
    }
}
