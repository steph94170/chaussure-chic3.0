<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SuperAdminFixtures extends Fixture
{
   
    // hasher pour encoder le mot de passe
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $superAdmin = $this->createSuperAdminFixtures();

        $manager->persist($superAdmin);

        $manager->flush();
    }

    private function createSuperAdminFixtures() : User
    {
        $superAdmin = new User();

        $passwordHashed = $this->hasher->hashPassword($superAdmin, "Stephanekoffi91!");

        $superAdmin->setFirstName("Stéphane");
        $superAdmin->setLastName("koffi");
        $superAdmin->setEmail("chaussure-chic@gmail.com");
        $superAdmin->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN','ROLE_USER']);
        $superAdmin->setPassword("$passwordHashed");
        $superAdmin->setIsVerified(true);
        $superAdmin->setCreatedAt(new DateTimeImmutable());
        $superAdmin->setVerifiedAt(new DateTimeImmutable());
        $superAdmin->setUpdatedAt(new DateTimeImmutable());

        return $superAdmin ;
    }
}
