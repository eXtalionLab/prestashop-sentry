<?php

declare(strict_types=1);

namespace Extalion\Sentry\Controller\Admin;

use Extalion\Sentry\Entity\ExtsentryConfiguration as ConfigurationEntity;
use Extalion\Sentry\Form\Type\Configuration as ConfigurationType;
use Extalion\Sentry\ToolbarButton\ToolbarButton;
use Extalion\Sentry\ToolbarButton\ToolbarButtonCollection;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigurationController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request): Response
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $configurations = $em->getRepository(ConfigurationEntity::class)
            ->findAll()
        ;
        $data = $this->configurationToArray($configurations);

        $form = $this->createForm(ConfigurationType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            foreach ($data as $name => $value) {
                $configuration = $this->createConfiguration(
                    $configurations,
                    $name,
                    (string) $value
                );

                $em->persist($configuration);
            }

            $em->flush();

            $this->addFlash('success', 'Configuration saved');
        }

        $language = $this->getContext()->language;

        return $this->render(
            '@Modules/extsentry/views/templates/admin/configuration.html.twig',
            [
                'layoutTitle' => $this->trans(
                    'Sentry configuration',
                    'Modules.Extsentry.Admin'
                ),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons()
                    ->toArray(),
                'form' => $form->createView(),
            ]
        );
    }

    private function configurationToArray(array &$configurations): array
    {
        $data = [];

        foreach ($configurations as $configuration) {
            $configName = $configuration->getName();
            $configurations[$configName] = $configuration;
            $data[$configName] = $configuration->getValue();
        }

        return $data;
    }

    private function createConfiguration(
        array $configurations,
        string $name,
        string $value
    ): ConfigurationEntity {
        if (isset($configurations[$name])) {
            return $configurations[$name]->setValue($value);
        }

        return (new ConfigurationEntity())
            ->setName($name)
            ->setValue($value)
        ;
    }

    private function getToolbarButtons(): ToolbarButtonCollection
    {
        $language = $this->getContext()->language;

        return (new ToolbarButtonCollection())
            ->add(
                (new ToolbarButton('translation'))
                    ->setClass('btn-outline-secondary')
                    ->setHelp($this->trans(
                        'Module translation',
                        'Modules.Extsentry.Admin'
                    ))
                    ->setHref($this->generateUrl(
                        'admin_international_translation_overview',
                        [
                            'lang' => $language->iso_code,
                            'locale' => $language->locale,
                            'type' => 'modules',
                            'selected' => 'extsentry',
                        ]
                    ))
                    ->setIcon('language')
                    ->setName($this->trans(
                        'Translation',
                        'Modules.Extsentry.Admin'
                    ))
            )
        ;
    }
}
