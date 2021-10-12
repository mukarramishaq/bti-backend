<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Exchange;
use App\Entity\StockPrice;
use App\Entity\StockType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockPrice[]    findAll()
 * @method StockPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockPriceRepository extends ServiceEntityRepository
{
    public $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockPrice::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function create(StockPrice $object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function update(StockPrice $object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function updateById($id, $data = [])
    {
        $object = $this->find($id);
        foreach ($data as $fieldName => $value) {
            $object->{'set' . \ucfirst($fieldName)}($value);
        }
        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function delete(StockPrice $object)
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
        return $object;
    }

    public function deleteById($id)
    {
        $object = $this->find($id);
        $this->entityManager->remove($object);
        $this->entityManager->flush();
        return $object;
    }

    public function getCompanyStockPrices(Company $company, StockType $stockType)
    {
        return $this->createQueryBuilder('sp')
            ->innerJoin(Exchange::class, 'e', Join::WITH, 'sp.exchange = e.id')
            ->innerJoin(Company::class, 'c', Join::WITH, 'sp.company = c.id')
            ->innerJoin(StockType::class, 'st', Join::WITH, 'sp.stockType = st.id')
            ->where('c.id = :companyId')
            ->andWhere('st.id = :stockTypeId')
            ->setParameter('companyId', $company->getId())
            ->setParameter('stockTypeId', $stockType->getId())
            ->groupBy('e.id')
            ->orderBy('sp.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getExchangePrices(Exchange $exchange)
    {
        return $this->createQueryBuilder('sp')
            ->innerJoin(Exchange::class, 'e', Join::WITH, 'sp.exchange = e.id')
            ->innerJoin(Company::class, 'c', Join::WITH, 'sp.company = c.id')
            ->innerJoin(StockType::class, 'st', Join::WITH, 'sp.stockType = st.id')
            ->where('e.id = :exchangeId')
            ->setParameter('exchangeId', $exchange->getId())
            ->groupBy('c.id')
            ->addGroupBy('st.id')
            ->orderBy('sp.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return StockPrice[] Returns an array of StockPrice objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('s')
    ->andWhere('s.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('s.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?StockPrice
{
return $this->createQueryBuilder('s')
->andWhere('s.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
