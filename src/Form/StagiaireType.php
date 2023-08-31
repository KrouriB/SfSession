<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom', TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'prenom', TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'dateNaissance', DateType::class, [
                    'widget' =>'single_text',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'email', EmailType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'telephone', TextType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '10',
                        'maxlength' => '10',
                        'type' => 'number'
                    ]
                ]
            )
            ->add(
                'sexe', ChoiceType::class, [
                    'choices'  => [
                        'M' => 'M',
                        'F' => 'F'
                    ],
                ]
            )
            ->add(
                'ville', TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'valider', SubmitType::class, [
                    'attr' => [
                        'class' => 'btn btn-success'
                    ]
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Stagiaire::class,
            ]
        );
    }
}
