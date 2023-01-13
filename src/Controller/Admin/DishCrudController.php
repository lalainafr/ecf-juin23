<?php

namespace App\Controller\Admin;

use App\Entity\Dish;

use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dish::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('description'),
            NumberField::new('price'),
            BooleanField::new('isFavorite'),
            // TextField::new('imageFile')->setFormType(VichImageType::class),    
            ImageField::new('image')
                ->setBasePath('uploads/dish/')
                ->setUploadDir('public/uploads/dish/'),
            DateTimeField::new('createdAt'),
        ];
    }

}
