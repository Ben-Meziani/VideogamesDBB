<?php

namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Videogame;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTest extends KernelTestCase
{


    public function testTestsAreWorking(){
        $videogame = (new Videogame())
                ->setReleaseDate(new \DateTime("2020-01-01 03:02:26"))
                ->setName('MIIIIIIII');
            self::bootKernel();
            $error = self::$container->get('validator')->validate($videogame);
            $this->assertCount(0, $error);
    }
}