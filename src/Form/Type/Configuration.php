<?php

declare(strict_types=1);

namespace Extalion\ModuleName\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type as CoreType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Configuration extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add(
                'config_1',
                CoreType\TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                    'label' => 'Module name config 1',
                    'required' => true,
                ]
            )
            ->add(
                'config_2',
                CoreType\NumberType::class,
                [
                    'label' => 'Module name config 2',
                    'required' => true,
                ]
            )
        ;

        $builder
            ->get('config_1')
            ->addModelTransformer(new CallbackTransformer(
                fn ($value) => $value,
                fn ($value) => (int) $value
            ))
        ;
    }
}
