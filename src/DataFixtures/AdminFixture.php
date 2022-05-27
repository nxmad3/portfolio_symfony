<?php

namespace App\DataFixtures;
/**
 * Use it only if u need to put a new user o, the bdd.
 */

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setEmail("root@root.fr");
        $user->setNom("ROOT");
        $user->setPrenom("root");
        $password = $this->hasher->hashPassword($user, 'root' );
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

}