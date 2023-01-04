<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield Field::new('city');
        yield Field::new('year');
        yield Field::new('isInternational');
        yield Field::new('slug')->onlyOnIndex();
    }
}
