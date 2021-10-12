<?php

namespace App\Repository;

use App\Entity\Exchange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exchange|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exchange|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exchange[]    findAll()
 * @method Exchange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRepository extends ServiceEntityRepository
{
    public $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exchange::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function create(Exchange $object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function update(Exchange $object)
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

    public function delete(Exchange $object)
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

    // /**
    //  * @return Exchange[] Returns an array of Exchange objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('e')
    ->andWhere('e.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('e.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?Exchange
{
return $this->createQueryBuilder('e')
->andWhere('e.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
