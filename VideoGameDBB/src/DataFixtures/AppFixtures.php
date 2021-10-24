<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Videogame;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $categoryArray = ['FPS', 'Action', 'Aventure', 'Stratégie', 'Jeux de société'];
        $categoryList = [];
        $videogameList = [];
        for ($i = 0; $i < count($categoryArray); $i++) {
            $category = new Category;
            $category->setLabel($categoryArray[$i]);
            $manager->persist($category);
            $categoryList[] = $category;
        }

        for($j = 0; $j <= 5; $j++){
            $videogame = new Videogame;
            $videogame
                    ->setName($faker->company)
                    ->setReleaseDate($faker->dateTimeBetween('-5 years', 'now'));
            //Cette boucle sert à ajouter entre une et 5 catégories à un jeux
            for($k = 0; $k <= mt_rand(1, 2); $k++){
             //L'index du tableau commençant a 0, on retire 1 pour être sur de récupérer une valeur existante dans le tableau
                $categoryRandom = $categoryList[mt_rand(0, count($categoryList)-1)];
                //Ici on vérifie qu'un jeu n'est pas lié à une catégorie pour éviter les doublons
                if(!$videogame->getCategories()->contains($categoryRandom)){
                    $videogame->addCategory($categoryRandom);
                }
            }
            $manager->persist($videogame);
            $videogameList[] = $videogame;
        }

        for($q = 0; $q < 3; $q++){
            $user = new User;
            $name = $faker->firstName;
            $user
                ->setName($name)
                ->setEmail($name.$q . '@gmail.com')
                ->setIsVerified(true)
                ->setRoles(["ROLE_USER"])
                ->setPassword($this->passwordHasher->hashPassword($user, $q .'password'));
            for($r = 0; $r < mt_rand(0, 4); $r++){
                $categoryRandom = $categoryList[mt_rand(0, count($categoryList) -1)];
                if(!$user->getCategories()->contains($categoryRandom)){
                    $user->addCategory($categoryRandom);
                }
            }

            for($r = 0; $r < mt_rand(0, count($videogameList) - 1); $r++){
                $videogameRandom = $videogameList[mt_rand(0, count($videogameList) -1)];
                if(!$user->getVideogames()->contains($videogameRandom)){
                    $user->addVideogame($videogameRandom);
                }
            }
        
            $manager->persist($user);
        }

        $manager->flush();
    }
}
