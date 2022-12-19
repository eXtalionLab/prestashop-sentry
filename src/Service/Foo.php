<?php

declare(strict_types=1);

namespace Extalion\ModuleName\Service;

use Extalion\ModuleName\Repository\Configuration;
use PrestaShop\PrestaShop\Adapter\Module\ModuleDataProvider;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;
use PrestaShopBundle\Translation\TranslatorAwareTrait;

class Foo
{
    use TranslatorAwareTrait;

    private int $contextLangId;
    private int $contextShopId;
    private ModuleDataProvider $moduleProvider;
    private ConfigurationInterface $shopConfiguration;
    private Configuration $moduleConfiguration;

    public function __construct(
        int $contextLangId,
        int $contextShopId,
        ModuleDataProvider $moduleProvider,
        ConfigurationInterface $shopConfiguration,
        Configuration $moduleConfiguration
    ) {
        $this->contextLangId = $contextLangId;
        $this->contextShopId = $contextShopId;
        $this->moduleProvider = $moduleProvider;
        $this->shopConfiguration = $shopConfiguration;
        $this->moduleConfiguration = $moduleConfiguration;
    }

    public function run(): void
    {
        if ($this->moduleProvider->isInstalled('OTHER_MODULE_CONFIG')) {
            $this->shopConfiguration->get('OTHER_MODULE_CONFIG');
        } else {
            $this->moduleConfiguration->get('MODULE_CONFIG');
        }

        $this->trans('Lorem ipsum', [], 'Modules.Extmodulename.Admin');
    }
}
