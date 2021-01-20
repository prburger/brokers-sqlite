<?php

namespace App\Repository;

use App\Entity\Supplier;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    public function findByBroker($id)
    {
        return $this->createQueryBuilder('s')
        ->where('s.broker_id=:val')
        ->setParameter('val', $id)
        ->orderBy('s.broker_id', 'ASC')
        ->getQuery()
        ->getResult()
        ;
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
           ->orderBy('p.id', 'DESC')
        ;      

        return (new Paginator($qb))->paginate($page);
    }
}
