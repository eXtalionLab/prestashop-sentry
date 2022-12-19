<?php

declare(strict_types=1);

namespace Extalion\Sentry\Command;

use PrestaShop\PrestaShop\Adapter\LegacyContextLoader;
use PrestaShopBundle\Translation\TranslatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FooCommand extends Command
{
    private TranslatorInterface $translator;
    private LegacyContextLoader $contextLoader;

    public function __construct(
        TranslatorInterface $translator,
        LegacyContextLoader $contextLoader
    ) {
        $this->translator = $translator;
        $this->contextLoader = $contextLoader;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('extalion:sentry:foo')
            ->setDescription($this->translator->trans(
                'Sentry command description',
                [],
                'Modules.Extsentry.Admin'
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->contextLoader->loadEmployeeContext()->loadGenericContext();
        $io = new SymfonyStyle($input, $output);

        try {
            $number = \random_int(\PHP_INT_MIN, PHP_INT_MAX);

            if ($number % 2) {
                throw new \Exception("Number \"{$number}\" is odd");
            }
        } catch (\Exception $ex) {
            $io->error('Foo command fail: ' . $ex->getMessage());

            return 1;
        }

        $io->success($this->translator->trans(
            'Foo command success',
            [],
            'Modules.Extsentry.Admin'
        ));

        return 0;
    }
}
