<?php

namespace App\Repository;

use App\Entity\Craft;
use App\Helper\PaginationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Craft|null find($id, $lockMode = null, $lockVersion = null)
 * @method Craft|null findOneBy(array $criteria, array $orderBy = null)
 * @method Craft[]    findAll()
 * @method Craft[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CraftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Craft::class);
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
    //  * @return Craft[] Returns an array of Craft objects
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
    public function findOneBySomeField($value): ?Craft
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
