<?php

declare(strict_types=1);

namespace Extalion\Sentry\Form\Type;

use Extalion\Sentry\Consts\ErrorTypesRegex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type as CoreType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Configuration extends AbstractType
{
    public const ENV_PROD = 'production';
    public const ENV_DEV = 'development';

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add(
                'dsn',
                CoreType\TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                    'label' => 'DSN',
                    'required' => true,
                ]
            )
            ->add(
                'error_types',
                CoreType\TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'E_ALL',
                    ],
                    'constraints' => [
                        new Assert\Regex('/' . ErrorTypesRegex::REGEX . '/'),
                    ],
                    'label' => 'Error types',
                    'required' => false,
                ]
            )
            ->add(
                'sample_rate',
                CoreType\NumberType::class,
                [
                    'attr' => [
                        'placeholder' => '1.0',
                    ],
                    'constraints' => [
                        new Assert\Range(['max' => 1.0, 'min' => 0]),
                    ],
                    'label' => 'Sample rate',
                    'required' => false,
                ]
            )
            ->add(
                'server_name',
                CoreType\TextType::class,
                [
                    'label' => 'Server name',
                    'required' => false,
                ]
            )
            ->add(
                'environment',
                CoreType\ChoiceType::class,
                [
                    'choices' => [
                        'Production' => self::ENV_PROD,
                        'Development' => self::ENV_DEV,
                    ],
                    'label' => 'Environment',
                    'required' => false,
                ]
            )
        ;

        $builder
            ->get('sample_rate')
            ->addModelTransformer(new CallbackTransformer(
                fn ($value) => (float) $value,
                fn ($value) => $value
            ))
        ;
    }
}
