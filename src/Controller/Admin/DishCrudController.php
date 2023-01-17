<?php

namespace App\Controller\Admin;

use App\Controller\DishController;
use App\Entity\Dish;

use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class DishCrudController extends AbstractCrudController
{
    public const BASE_PATH = 'uploads/dish/';
    public const UPLOAD_DIR = 'public/uploads/dish/';

    public static function getEntityFqcn(): string
    {
        return Dish::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Nom du plat'),
            TextField::new('description', 'Description'),
            NumberField::new('price', 'Price'),
            BooleanField::new('isFavorite', 'Plat préféré'), 
            ImageField::new('image', 'Image')
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR),
            AssociationField::new('Category', 'Catégorie'),
            DateTimeField::new('createdAt', 'Date de création'),
        ];
    }

}
