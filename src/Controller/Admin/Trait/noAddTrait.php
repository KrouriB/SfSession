<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

trait noAddTrait
{
    public function configureActions(Actions $actions) : Actions
    {
        $actions
            ->disable(Action::NEW);
        return $actions;
    }
}