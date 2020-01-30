<?php

namespace App\Repository;

use App\Entity\Harvest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Harvest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Harvest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Harvest[]    findAll()
 * @method Harvest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HarvestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Harvest::class);
    }

    public function deleteAllHigherThanId(int $_id)
    {
        $this->createQueryBuilder('q')
            ->delete()
            ->where('q._id >= :external_id')
            ->setParameter('external_id', $_id)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Harvest[] Returns an array of Harvest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Harvest
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
