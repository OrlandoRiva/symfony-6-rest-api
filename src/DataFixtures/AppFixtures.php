<?php

namespace App\DataFixtures;

use App\Factory\ProjectFactory;
use App\Factory\ThemeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ThemeFactory::createMany(5);
        ProjectFactory::createMany(20);
    }
}
