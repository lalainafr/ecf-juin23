<?php

namespace App\Controller\Admin;

use App\Entity\Open;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OpenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Open::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
