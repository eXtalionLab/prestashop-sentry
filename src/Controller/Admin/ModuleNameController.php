<?php

declare(strict_types=1);

namespace Extalion\ModuleName\Controller\Admin;

use Extalion\ModuleName\Service\Foo;
use Extalion\ModuleName\ToolbarButton\ToolbarButton;
use Extalion\ModuleName\ToolbarButton\ToolbarButtonCollection;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleNameController extends FrameworkBundleAdminController
{
    private Foo $foo;

    public function __construct(Foo $foo)
    {
        parent::__construct();

        $this->foo = $foo;
    }

    public function indexAction(Request $request): Response
    {
        $referer = $request->server->get('HTTP_REFERER');
        $message = $this->trans(
            'Lorem ipsum from %referer%',
            'Modules.Extmodulename.Admin',
            [
                '%referer%' => $referer,
            ]
        );

        return $this->render(
            '@Modules/extmodulename/views/templates/admin/index.html.twig',
            [
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons()
                    ->toArray(),
                'message' => $message,
            ]
        );
    }

    private function getToolbarButtons(): ToolbarButtonCollection
    {
        return (new ToolbarButtonCollection())
            ->add(
                (new ToolbarButton('config'))
                    ->setClass('btn-secondary')
                    ->setHelp($this->trans(
                        'Module config page',
                        'Modules.Extmodulename.Admin'
                    ))
                    ->setHref($this->generateUrl(
                        'extalion_modulename_configuration'
                    ))
                    ->setIcon('settings')
                    ->setName($this->trans(
                        'Config',
                        'Modules.Extmodulename.Admin'
                    ))
            )
        ;
    }
}
