<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\StockPrice;
use App\Entity\StockType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockType|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockType|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockType[]    findAll()
 * @method StockType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockTypeRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockType::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function create(StockType $object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function update(StockType $object)
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

    public function delete(StockType $object)
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

    public function getAllofCompany(Company $company)
    {
        return $this->createQueryBuilder('st')
            ->innerJoin(StockPrice::class, 'sp', Join::WITH, 'sp.stockType = st.id')
            ->innerJoin(Company::class, 'c', Join::WITH, 'c.id = sp.company')
            ->where('c.id = :companyId')
            ->setParameter('companyId', $company->getId())
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return StockType[] Returns an array of StockType objects
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
public function findOneBySomeField($value): ?StockType
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
