<?php

namespace App\Repository;

use App\Entity\Buy;
use App\Helper\PaginationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Buy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Buy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Buy[]    findAll()
 * @method Buy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Buy::class);
    }

    public function deleteAllHigherThanId(int $_id)
    {
        $this->createQueryBuilder('q')
            ->delete()
            ->where('q.external_id >= :external_id')
            ->setParameter('external_id', $_id)
            ->getQuery()
            ->getResult();
    }

    public function findPaginatedForPortal($options)
    {
        $query = $this->createQueryBuilder('q');

        return PaginationHelper::portalPaginationQueryBuilder($query, $options);
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    public function countPaginatedAll($options)
    {
        $query = $this->createQueryBuilder('q')
            ->select('COUNT(DISTINCT(q.id))');

        return PaginationHelper::portalPaginationCountQueryBuilder($query, $options);
    }

    // /**
    //  * @return Buy[] Returns an array of Buy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Buy
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
