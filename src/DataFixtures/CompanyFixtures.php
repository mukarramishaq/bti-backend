<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class CompanyFixtures extends Fixture
{
    public const DATA = [
        [
            'name' => 'Google',
            'description' => 'Its google bro',
        ],
        [
            'name' => 'Facebook',
            'description' => 'Its facebook bro',
        ],
        [
            'name' => 'Allianz',
            'description' => 'Its allianz bro',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $currentDateTime = new DateTimeImmutable();
        foreach (self::DATA as $companyData) {
            $company = new Company();
            $company->setName($companyData['name']);
            $company->setDescription($companyData['description']);
            $company->setCreatedAt($currentDateTime);
            $company->setUpdatedAt($currentDateTime);
            $manager->persist($company);

            //reference for other fixtures
            $this->addReference($company->getName(), $company);
        }

        $manager->flush();
    }
}
