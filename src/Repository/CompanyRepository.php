<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function create(Company $object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function update(Company $object)
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

    public function delete(Company $object)
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
    //  * @return Company[] Returns an array of Company objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('c')
    ->andWhere('c.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('c.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?Company
{
return $this->createQueryBuilder('c')
->andWhere('c.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
