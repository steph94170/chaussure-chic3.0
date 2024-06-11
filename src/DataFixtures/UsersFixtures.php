<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user1 = $this->createUser1();
        $user2 = $this->createUser2();
        $user3 = $this->createUser3();

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);

        $manager->flush();
    }

    private function createUser1() : User
    {
        $user = new User();

        $passwordHashed = $this->hasher->hashPassword($user, "Stephanekoffi91!");

        $user->setFirstName("sasuke");
        $user->setLastName("uchiwa");
        $user->setEmail("sasuke@gmail.com");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword("$passwordHashed");
        $user->setIsVerified(true);
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setVerifiedAt(new DateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable());

        return $user ;
    }

    private function createUser2() : User
    {
        $user = new User();

        $passwordHashed = $this->hasher->hashPassword($user, "Stephanekoffi91!");

        $user->setFirstName("itachi");
        $user->setLastName("uchiwa");
        $user->setEmail("itachi@gmail.com");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword("$passwordHashed");
        $user->setIsVerified(true);
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setVerifiedAt(new DateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable());

        return $user ;
    }

    private function createUser3() : User
    {
        $user = new User();

        $passwordHashed = $this->hasher->hashPassword($user, "Stephanekoffi91!");

        $user->setFirstName("madara");
        $user->setLastName("uchiwa");
        $user->setEmail("madara@gmail.com");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword("$passwordHashed");
        $user->setIsVerified(true);
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setVerifiedAt(new DateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable());

        return $user ;
    }
}
