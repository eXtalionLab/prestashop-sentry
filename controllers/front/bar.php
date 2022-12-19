<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\JsonResponse;

class ExtModuleNameBarModuleFrontController extends ModuleFrontController
{
    public function displayAjaxIndexAction(): void
    {
        $response = new JsonResponse([
            'var' => 'new',
        ]);
        $response->send();
    }
}