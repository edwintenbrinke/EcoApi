<?php

namespace App\Repository;

use App\Entity\Play;
use App\Helper\PaginationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Play|null find($id, $lockMode = null, $lockVersion = null)
 * @method Play|null findOneBy(array $criteria, array $orderBy = null)
 * @method Play[]    findAll()
 * @method Play[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Play::class);
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
    //  * @return Play[] Returns an array of Play objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Play
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
