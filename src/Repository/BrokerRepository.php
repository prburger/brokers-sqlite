<?php

namespace App\Repository;

use App\Entity\Broker;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Broker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Broker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Broker[]    findAll()
 * @method Broker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrokerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Broker::class);
    }

    /**
     * Our findLatest() method
     *
     * 1. Create & pass query to paginate method
     * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
     * 3. Return that object to the controller
     *
     * @param integer $currentPage The current page (passed from controller)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function findLatest(int $currentPage = 1): Paginator
    {
        $qb = $this->createQueryBuilder('p')
           ->orderBy('p.id', 'DESC')
        ;      

        return (new Paginator($qb))->paginate($currentPage);
    }

    // /**
    //  * @return Broker[] Returns an array of Broker objects
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
    public function findOneBySomeField($value): ?Broker
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
