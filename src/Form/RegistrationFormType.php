<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email', EmailType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'pseudo', TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'agreeTerms', CheckboxType::class, [
                    'label_attr' => [
                        'class' => 'form-check-label ms-2'
                    ],
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue(
                            [
                            'message' => 'You should agree to our terms.',
                            ]
                        ),
                    ],
                    'attr' => [
                        'class' => 'form-check-input'
                    ]
                ]
            )
            ->add(
                'plainPassword', RepeatedType::class, [
                    'mapped' => false,
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field form-control']],
                    'required' => true,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ]
            )
            ->add(
                'valider', SubmitType::class, [
                    'attr' => [
                        'class' => 'btn btn-success ms-5'
                    ]
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'user_item',
            ]
        );
    }
}
