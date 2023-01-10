<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

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

        //User
            // création de l'user admin
            $admin = new User();
            $admin->setFullName('Administrateur du restaurant')
                ->setEmail('admin@lalaina-rajaonahsoa.com')
                ->setPassword($this->hasher->hashPassword($admin, 'admin'))
                ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $users[] = $admin;    
            $manager->persist($admin);  
            
            //création de 5 utilisateurs avec un mot de passe 'password' qui sera encodé
            for ($i=0; $i < 5; $i++) { 
                $user = new User();
                $user->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->hasher->hashPassword($user, 'password'));
                $users[] = $user;    
                $manager->persist($user);
            }

            $manager->flush();

    }
    

    
}