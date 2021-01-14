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

    public function findWithoutId($value)
    {
        return $this->createQueryBuilder('b')
        ->where('b.id != :val')
        ->setParameter('val', $value)
        ->orderBy('b.id', 'ASC')
        // ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findByName($value)
    {
        return $this->createQueryBuilder('b')
        ->where('b.name = :val')
        ->setParameter('val', $value)
        ->orderBy('b.id', 'ASC')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findWithoutName($value)
    {
        return $this->createQueryBuilder('b')
        ->where('b.name != :val')
        ->setParameter('val', $value)
        ->orderBy('b.id', 'ASC')
        // ->setMaxResults(1)
        ->getQuery()
        ->getResult()
        ;
    }

/*     public function createQueryBuilder()
    {
        return $this->createQueryBuilder('b')
        // ->andWhere('b.exampleField = :val')
        // ->setParameter('val', $value)
        ->orderBy('b.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    } */

    /**
     * Our findLatest() method
     *
     * 1. Create & pass query to paginate method
     * 2. Paginate will return a `App\Pagination\Paginator` object
     * 3. Return that object to the controller
     *
     * @param integer $page The current page (passed from controller)
     *
     * @return \App\Pagination\Paginator;
     */
    public function findLatest(int $page = 1): Paginator
    {
        $qb = $this->createQueryBuilder('p')
           ->orderBy('p.dateAdded', 'ASC')
        ;      

        return (new Paginator($qb))->paginate($page);
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
