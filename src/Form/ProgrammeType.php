<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $sessionId = $options['session_id'];

        $builder
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'nom', // Affiche le champ 'nom' de l'entité Module
                'label' => 'Module',
                'placeholder' => 'Sélectionnez un module', // Optionnel : affiche un libellé de sélection
            ])
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'nom', // Affiche le champ 'nom' de l'entité Module
                'label' => 'Session',
                'placeholder' => 'Sélectionnez un session', // Optionnel : affiche un libellé de sélection
            ])
            ->add('nombreJours', IntegerType::class, [
                'label' => 'Nombre de Jours',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configurez ici les options du formulaire, si nécessaire.
            //'data_class' => 'App\Entity\Programme',
        ]);
    }

    
}