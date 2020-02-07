<?php

namespace App\Repository;

use App\Entity\Offer;
use App\Entity\User;
use App\Helper\PaginationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function findAllForUser(User $user)
    {
        return $this->createQueryBuilder('q')
            ->where('q.user = :user_id')
            ->setParameter('user_id', $user->getId())
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
    //  * @return Offer[] Returns an array of Offer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offer
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
