<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use App\Entity\Programme;
use App\Form\ProgrammeType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('nom'),
            DateField::new('dateDebut'),
            DateField::new('dateFin'),
            NumberField::new('nombrePlaceTheorique'),
            AssociationField::new('stagiaires')
                ->setFormTypeOptions(
                    [
                    'by_reference' => false,
                    ]
                ),
            ArrayField::new('programmes')
                ->hideOnIndex(),
            TextField::new('formation')
                ->onlyOnIndex(),
            AssociationField::new('formation')
                ->hideOnIndex(),
            AssociationField::new('programmes')
                ->onlyOnIndex(),
            CollectionField::new('programmes')
                ->onlyOnForms()
                ->setEntryIsComplex(true) // Indique que chaque entrée est complexe (Module + nombre de jours)
                ->setFormTypeOptions(
                    [
                    // 'entry_type' => ProgrammeType::class, // Le formulaire pour chaque entrée
                    'allow_add' => true, // Autoriser l'ajout de nouvelles entrées
                    'allow_delete' => true, // Autoriser la suppression d'entrées existantes
                    'by_reference' => false, // Nécessaire pour que les modifications soient persistées correctement
                    ]
                )
                ->setEntryType(ProgrammeType::class), // Le formulaire pour chaque entrée
        ];
    }
}
