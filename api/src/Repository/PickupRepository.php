<?php

namespace App\Repository;

use App\Entity\Pickup;
use App\Helper\PaginationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pickup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pickup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pickup[]    findAll()
 * @method Pickup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pickup::class);
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
    //  * @return Pickup[] Returns an array of Pickup objects
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
    public function findOneBySomeField($value): ?Pickup
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
