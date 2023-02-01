<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Open;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Formula;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\VarDumper\Caster\ImgStub;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // Implementer FAKER
    /**
     * @var Generator
     */
    private Generator $faker;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }

    // Mise en place des FIXTURES
    public function load(ObjectManager $manager)
    {

        //USER
        // création de l'user admin
        $admin = new User();
        $admin->setFullName('Administrateur du restaurant')
            ->setEmail('admin@lalaina-rajaonahsoa.com')
            ->setPassword($this->hasher->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $users[] = $admin;
        $manager->persist($admin);

        //création d'1 admin et de  5 clients avec un mot de passe 'password' qui sera encodé
        for ($i = 0; $i < 5; $i++) {
            $client = new User();
            $client->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->hasher->hashPassword($client, 'azerty'));
            $users[] = $client;
            $manager->persist($client);
        }

        //CATEGORY    
        $listCategory = ['Entrée', 'Plat de resistance', 'Dessert', 'Burger'];
        for ($i = 0; $i < 4; $i++) {
            $category = new Category();
            $category->setName($listCategory[$i]);
            $categories[] = $category;
            $manager->persist($category);
        }


        //PLAT
        for ($i = 0; $i < 14; $i++) {
            $dish = new Dish();
            $dish->setTitle('plat - ' . strtoupper($this->faker->text(10)))
                ->setDescription($this->faker->text(200))
                ->setPrice($this->faker->numberBetween(1, 50))
                ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false)
                ->setCategory($this->faker->randomElement($categories));

            $img = ['bananas.jpg', 'braise-pork.jpg', 'burger.jpeg', 'burger1.jpeg', 'burger2.jpeg', 'cake.jpg', 'cake1.jpg', 'charcuterie.jpg', 'pancakes.jpg', 'chocolates.jpg', 'salade.jpeg', 'salade1.jpeg', 'salade2.jpg', 'fish.jpeg'];

            $dish->setImage($img[$i]);

            $dishes[] = $dish;

            $manager->persist($dish);
        }

        // FORMULE
        for ($i = 0; $i < 4; $i++) {
            $formula = new Formula();
            $formula->setName('formula - ' . strtoupper($this->faker->text(10)))
                ->setPrice($this->faker->numberBetween(10, 30))
                ->setDescription($this->faker->sentence(4));

            for ($j = 0; $j < mt_rand(2, 3); $j++) {
                $formula->addDish($dishes[mt_rand(1, count($dishes) - 1)]);
            }

            $formulas[] = $formula;

            $manager->persist($formula);
        }

        // MENU
        for ($i = 0; $i < 3; $i++) {
            $menu = new Menu();
            $menu->setTitle('menu - ' . strtoupper($this->faker->text(6)));
            for ($j = 0; $j < mt_rand(2, 4); $j++) {
                $menu->addFormula($formulas[mt_rand(1, count($formulas) - 1)]);
            }

            $manager->persist($menu);
        }


        // HORAIRE D'OUVERTURE
        $day = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        for ($i=0; $i < 7; $i++) { 
            $open = new Open();
            $open->setDay($day[$i])    
                ->setAmStart('12h')       
                ->setAmClose('14h')
                ->setPmStart('19h')
                ->setPmClose('22h');
            $manager->persist($open);
        }

        $manager->flush();
    }    
}
