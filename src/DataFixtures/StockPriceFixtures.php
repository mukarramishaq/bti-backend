<?php

namespace App\DataFixtures;

use App\DataFixtures\CompanyFixtures;
use App\DataFixtures\ExchangeFixtures;
use App\DataFixtures\StockTypeFixtures;
use App\Entity\StockPrice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use DateTimeImmutable;

class StockPriceFixtures extends Fixture implements DependentFixtureInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     * this will make sure, this fixture will
     * run once its all other fixtures, upon which
     * it is dependent, are executed
     */
    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            ExchangeFixtures::class,
            StockTypeFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $data = [
            /*******  Company 1  ********/
            //### company 1 exchange 1
            [
                'company' => CompanyFixtures::DATA[0]['name'],
                'exchange' => ExchangeFixtures::DATA[0]['name'],
                'stockType' => StockTypeFixtures::DATA[0]['name'],
                'price' => 10000, //in cents to avoid rounding errors
            ],
            [
                'company' => CompanyFixtures::DATA[0]['name'],
                'exchange' => ExchangeFixtures::DATA[0]['name'],
                'stockType' => StockTypeFixtures::DATA[1]['name'],
                'price' => 12000, //in cents to avoid rounding errors
            ],
            //### company 1 exchange 2
            [
                'company' => CompanyFixtures::DATA[0]['name'],
                'exchange' => ExchangeFixtures::DATA[1]['name'],
                'stockType' => StockTypeFixtures::DATA[0]['name'],
                'price' => 10001, //in cents to avoid rounding errors
            ],
            [
                'company' => CompanyFixtures::DATA[0]['name'],
                'exchange' => ExchangeFixtures::DATA[1]['name'],
                'stockType' => StockTypeFixtures::DATA[1]['name'],
                'price' => 12002, //in cents to avoid rounding errors
            ],
            //### company 1 exchange 3
            [
                'company' => CompanyFixtures::DATA[0]['name'],
                'exchange' => ExchangeFixtures::DATA[2]['name'],
                'stockType' => StockTypeFixtures::DATA[0]['name'],
                'price' => 10001, //in cents to avoid rounding errors
            ],
            //exhange 4
            [
                'company' => CompanyFixtures::DATA[0]['name'],
                'exchange' => ExchangeFixtures::DATA[4]['name'],
                'stockType' => StockTypeFixtures::DATA[1]['name'],
                'price' => 12002, //in cents to avoid rounding errors
            ],
            /*******  Company 2  ********/
            //### company 2 exchange 1
            [
                'company' => CompanyFixtures::DATA[1]['name'],
                'exchange' => ExchangeFixtures::DATA[0]['name'],
                'stockType' => StockTypeFixtures::DATA[0]['name'],
                'price' => 15000, //in cents to avoid rounding errors
            ],
            //### company 2 exchange 2
            [
                'company' => CompanyFixtures::DATA[1]['name'],
                'exchange' => ExchangeFixtures::DATA[1]['name'],
                'stockType' => StockTypeFixtures::DATA[0]['name'],
                'price' => 15001, //in cents to avoid rounding errors
            ],
            //### company 2 exchange 3
            [
                'company' => CompanyFixtures::DATA[1]['name'],
                'exchange' => ExchangeFixtures::DATA[2]['name'],
                'stockType' => StockTypeFixtures::DATA[0]['name'],
                'price' => 15001, //in cents to avoid rounding errors
            ],
            /*******  Company 3  ********/
            //### company 3 exchange 1
            [
                'company' => CompanyFixtures::DATA[2]['name'],
                'exchange' => ExchangeFixtures::DATA[0]['name'],
                'stockType' => StockTypeFixtures::DATA[1]['name'],
                'price' => 12000, //in cents to avoid rounding errors
            ],
            //### company 3 exchange 2
            [
                'company' => CompanyFixtures::DATA[2]['name'],
                'exchange' => ExchangeFixtures::DATA[1]['name'],
                'stockType' => StockTypeFixtures::DATA[1]['name'],
                'price' => 12002, //in cents to avoid rounding errors
            ],
            //### company 3 exchange 3
            //exhange 4
            [
                'company' => CompanyFixtures::DATA[2]['name'],
                'exchange' => ExchangeFixtures::DATA[4]['name'],
                'stockType' => StockTypeFixtures::DATA[1]['name'],
                'price' => 1202, //in cents to avoid rounding errors
            ],
        ];
        $currentDateTime = new DateTimeImmutable();
        foreach ($data as $priceData) {
            try {
                $price = new StockPrice();
                $price->setStockType($this->getReference($priceData['stockType']));
                $price->setExchange($this->getReference($priceData['exchange']));
                $price->setCompany($this->getReference($priceData['company']));
                $price->setCreatedAt($currentDateTime);
                $price->setUpdatedAt($currentDateTime);
                $price->setPrice($priceData['price']);
                $manager->persist($price);
            } catch (\Error $e) {
                $this->logger->error($e->getMessage());
            }
        }
        $manager->flush();
    }
}
