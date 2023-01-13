<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Dish;
use App\Entity\User;
use Faker\Generator;
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

    public function __construct( UserPasswordHasherInterface $hasher)
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
            for ($i=0; $i < 5; $i++) { 
                $client = new User();
                $client->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->hasher->hashPassword($client, 'azerty'));
                $users[] = $client;    
                $manager->persist($client);
            }

        //PLAT


        for ($i=0; $i < 12; $i++) { 
            $dish = new Dish();
            $dish->setTitle('plat - ' . strtoupper($this->faker->text(10)));
            $dish->setDescription($this->faker->text(200));
            $dish->setPrice($this->faker->numberBetween(0, 1000));
            $dish->setIsFavorite(mt_rand(0,1) == 1 ? true : false);

            $img0 =  'https://cdn.pixabay.com/photo/2016/03/17/23/30/salad-1264107_960_720.jpg';
            $img1 =  'https://cdn.pixabay.com/photo/2014/11/05/15/57/salmon-518032_960_720.jpg';
            $img2 =  'https://cdn.pixabay.com/photo/2016/09/15/19/24/salad-1672505_960_720.jpg';
            $img3 =  'https://cdn.pixabay.com/photo/2017/11/10/15/04/steak-2936531_960_720.jpg';
            $img4 =  'https://cdn.pixabay.com/photo/2013/06/09/06/07/meat-123668_960_720.jpg';
            $img5 =  'https://cdn.pixabay.com/photo/2016/03/05/19/02/hamburger-1238246_960_720.jpg';
            $img6 =  'https://cdn.pixabay.com/photo/2016/03/05/20/07/grilled-1238668_960_720.jpg';
            $img7 =  'https://cdn.pixabay.com/photo/2014/08/14/14/21/shish-kebab-417994_960_720.jpg';
            $img8 =  'https://cdn.pixabay.com/photo/2014/05/05/19/52/charcuterie-338498_960_720.jpg';
            $img9 =  'https://cdn.pixabay.com/photo/2016/11/25/16/08/sushi-1858696_960_720.jpg';
            $img10 = 'https://cdn.pixabay.com/photo/2017/12/14/19/47/cake-3019645_960_720.jpg';
            $img11 = 'https://cdn.pixabay.com/photo/2017/02/17/23/23/strawberry-dessert-2076155_960_720.jpg';
            
            switch ($i) {
                case '0':
                    $dish->setImage($img0);
                    break;
                case '1':
                    $dish->setImage($img1);
                    break;
                case '2':
                    $dish->setImage($img2);
                    break;
                case '3':
                    $dish->setImage($img3);
                    break;
                case '4':
                    $dish->setImage($img4);
                    break;
                case '5':
                    $dish->setImage($img5);
                    break;
                case '6':
                    $dish->setImage($img6);
                    break;
                case '7':
                    $dish->setImage($img7);
                    break;
                case '8':
                    $dish->setImage($img8);
                    break;
                case '9':
                    $dish->setImage($img9);
                    break;
                case '10':
                    $dish->setImage($img10);
                    break;
                default:
                    $dish->setImage($img11);
                    break;
            }
            $manager->persist($dish);
        }
        $manager->flush();
    }
    
}

