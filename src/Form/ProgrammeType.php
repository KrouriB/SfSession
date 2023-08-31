<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $sessionId = $options['session_id'];

        $builder
            ->add(
                'module',
                EntityType::class,
                [
                    'class' => Module::class,
                    'choice_label' => 'nom', // Affiche le champ 'nom' de l'entité Module
                    'label' => 'Module',
                    'placeholder' => 'Sélectionnez un module', // Optionnel : affiche un libellé de sélection
                ]
            )
            ->add(
                'session',
                EntityType::class,
                [
                    'class' => Session::class,
                    'choice_label' => 'nom', // Affiche le champ 'nom' de l'entité Session
                    'label' => 'Session',
                    'row_attr' => ['style' => 'display:none;'], // En mode lecture seule
                ]
            )
            ->add(
                'nombreJours',
                IntegerType::class,
                [
                    'label' => 'Nombre de Jours',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Programme::class,
            ]
        );
    }
}
