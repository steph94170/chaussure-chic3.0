<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      
        $setting = $this->createSetting();     
        
        $manager->persist($setting);
        
        $manager->flush();
    }

    private function createSetting(): Setting
    {
        $setting = new Setting();

        $setting->setWebsiteName("chaussure-chic");
        $setting->setWebsiteUrl("http://chaussure-chic.com");
        $setting->setDescription("Acheter des produits interessant");
        $setting->setEmail("chaussure-chic@gmail.com");
        $setting->setPhone("+33 1 23 45 67 89");
        $setting->setStreet("123 Rue de Paris");
        $setting->setCity("Paris");
        $setting->setPostalCode("75001");
        $setting->setState("France");
        $setting->setCreatedAt(new DateTimeImmutable());
        $setting->setUpdatedAt(new DateTimeImmutable());
        
        return $setting;
    }
}
