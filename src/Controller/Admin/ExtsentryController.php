<?php

declare(strict_types=1);

namespace Extalion\Sentry\Controller\Admin;

use Extalion\Sentry\Service\Foo;
use Extalion\Sentry\ToolbarButton\ToolbarButton;
use Extalion\Sentry\ToolbarButton\ToolbarButtonCollection;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SentryController extends FrameworkBundleAdminController
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
            'Modules.Extsentry.Admin',
            [
                '%referer%' => $referer,
            ]
        );

        return $this->render(
            '@Modules/extsentry/views/templates/admin/index.html.twig',
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
                        'Modules.Extsentry.Admin'
                    ))
                    ->setHref($this->generateUrl(
                        'extalion_sentry_configuration'
                    ))
                    ->setIcon('settings')
                    ->setName($this->trans(
                        'Config',
                        'Modules.Extsentry.Admin'
                    ))
            )
        ;
    }
}
