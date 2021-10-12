<?php

namespace App\DataFixtures;

use App\Entity\StockType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class StockTypeFixtures extends Fixture
{
    public const DATA = [
        [
            'name' => 'Common',
        ],
        [
            'name' => 'Preferred',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $currentDateTime = new DateTimeImmutable();
        foreach (self::DATA as $stockTypeData) {
            $stockType = new StockType();
            $stockType->setName($stockTypeData['name']);
            $manager->persist($stockType);

            //reference for other fixtures
            $this->addReference($stockType->getName(), $stockType);
        }
        $manager->flush();
    }
}
