<?php

declare(strict_types=1);

if (!\defined('_PS_VERSION_')) {
    exit;
}

class ExtSentry extends Module
{
    private array $tabsConfig = [];

    public function __construct()
    {
        $this->name = 'extsentry';
        $this->tab = 'administration';
        $this->version = '0.1.0';
        $this->author = 'eXtalion.com';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans(
            'Sentry',
            [],
            'Modules.Extsentry.Admin'
        );
        $this->description = $this->trans(
            'Sentry description',
            [],
            'Modules.Extsentry.Admin'
        );

        $this->confirmUninstall = $this->trans(
            'Are you sure',
            [],
            'Modules.Extsentry.Admin'
        );

        $this->ps_versions_compliancy = [
            'min' => '1.7.8',
            'max' => _PS_VERSION_,
        ];
    }

    public function install(): bool
    {
        $sqlInstallResult = include __DIR__ . '/sql/install.php';

        return $sqlInstallResult
            && parent::install()
        ;
    }

    public function uninstall(): bool
    {
        $sqlUninstallResult = include __DIR__ . '/sql/uninstall.php';

        return $sqlUninstallResult
            && parent::uninstall()
        ;
    }

    public function enable($forceAll = false): bool
    {
        return parent::enable($forceAll)
            && $this->installTab()
        ;
    }

    public function disable($forceAll = false): bool
    {
        return parent::disable($forceAll)
            && $this->uninstallTab()
        ;
    }

    private function installTab(): bool
    {
        $tabRepository = $this->get('prestashop.core.admin.tab.repository');

        foreach ($this->tabsConfig as $tabConfig) {
            $tabId = $tabRepository
                ->findOneIdByClassName($tabConfig['class_name'])
            ;

            $tab = new Tab($tabId);
            $tab->id_parent = $tabRepository
                ->findOneIdByClassName($tabConfig['parent'])
            ;
            $tab->active = 1;
            $tab->class_name = $tabConfig['class_name'];
            $tab->icon = $tabConfig['icon'];
            $tab->module = $this->name;
            $tab->name = [];

            foreach (Language::getLanguages() as $lang) {
                $tab->name[$lang['id_lang']] = $this->trans(
                    $tabConfig['name'],
                    [],
                    'Modules.Extsentry.Admin',
                    $lang['locale']
                );
            }

            if (!(bool) $tab->save()) {
                return false;
            }
        }

        return true;
    }

    private function uninstallTab(): bool
    {
        $tabRepository = $this->get('prestashop.core.admin.tab.repository');

        foreach ($this->tabsConfig as $tabConfig) {
            $tabId = $tabRepository
                ->findOneIdByClassName($tabConfig['class_name'])
            ;

            if ($tabId) {
                $tab = new Tab($tabId);

                if (!(bool) $tab->delete()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink(
                'ExtSentryAdminConfigurationController',
                true,
                ['route' => 'extalion_sentry_configuration']
            )
        );
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
}
