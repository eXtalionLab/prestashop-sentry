<?php

declare(strict_types=1);

class ExtSentryFooModuleFrontController extends ModuleFrontController
{
    public function setMedia(): bool
    {
        parent::setMedia();

        $this->registerStylesheet(
            'extsentry-front-css',
            "{$this->module->getPathUri()}views/css/front.css"
        );
        $this->registerJavascript(
            'extsentry-front-js',
            "{$this->module->getPathUri()}views/js/front.js"
        );

        return true;
    }

    public function initContent(): void
    {
        $this->context->smarty->assign([
            'foo' => 'bar',
        ]);
        $this->setTemplate('module:extsentry/views/templates/front/foo.tpl');

        parent::initContent();
    }
}
