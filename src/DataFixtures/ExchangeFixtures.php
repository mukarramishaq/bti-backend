<?php

namespace App\DataFixtures;

use App\Entity\Exchange;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class ExchangeFixtures extends Fixture
{
    public const DATA = [
        [
            'name' => 'New York Stock Exchange',
            'description' => 'Its ny exchnage bro',
        ],
        [
            'name' => 'London Stock Exchange',
            'description' => 'Its london exchange bro',
        ],
        [
            'name' => 'Hong Kong Stock Exchange',
            'description' => 'Its hk exchange bro',
        ],
        [
            'name' => 'Karachi Stock Exchange',
            'description' => 'Its karachi exchange bro',
        ],
        [
            'name' => 'Deutsche Börse Frankfurt',
            'description' => 'Its DBF bro',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $currentDateTime = new DateTimeImmutable();
        foreach (self::DATA as $exchangeData) {
            $exchange = new Exchange();
            $exchange->setName($exchangeData['name']);
            $exchange->setDescription($exchangeData['description']);
            $exchange->setCreatedAt($currentDateTime);
            $exchange->setUpdatedAt($currentDateTime);
            $manager->persist($exchange);

            //reference for other fixtures
            $this->addReference($exchange->getName(), $exchange);
        }

        $manager->flush();
    }
}
