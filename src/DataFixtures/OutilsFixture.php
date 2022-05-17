<?php

namespace App\DataFixtures;

use App\Entity\Outils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OutilsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Outils = ['discord','slack','teams'];
        $images = ['<i class="fa-brands fa-discord"></i>','<i class="fa-brands fa-slack"></i>','teams.png'];
        $nb =0;
        foreach ($Outils as $outil) {
            $outils = new Outils();
            $outils->setLabel($outil);
            $outils->setImage($images[$nb]);
            $nb = $nb + 1;
            $manager->persist($outils);
        }

        $manager->flush();
    }
}