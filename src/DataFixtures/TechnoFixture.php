<?php

namespace App\DataFixtures;

use App\Entity\Techno;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnoFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $technos = ['HTML','CSS','JQuery','JAVASCRIPT','PHP','Symfony','WORDPRESS','MYSQL','C#'];
        $images = ['<i class="fa-brands fa-html5"></i>','<i class="fa-brands fa-css3-alt"></i>','jquery.png','<i class="fa-brands fa-js"></i>','<i class="fa-brands fa-php"></i>','<i class="fa-brands fa-symfony"></i>','<i class="fa-brands fa-wordpress"></i>','mysql.png','csharp.png'];
        $nb =0;
        foreach ($technos as $techno) {
            $thech = new Techno();
            $thech->setLabel($techno);
            $thech->setImage($images[$nb]);
            $nb = $nb + 1;
            $manager->persist($thech);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
