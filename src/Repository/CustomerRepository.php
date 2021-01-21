<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findWithoutId($value)
    {
        return $this->createQueryBuilder('b')
        ->where('b.id != :val')
        ->setParameter('val', $value)
        ->orderBy('b.id', 'ASC')
        ->getQuery()
        ->getResult();
    }
    
    public function findByBroker($id)
    {
        return $this->createQueryBuilder('c')
        ->where('c.broker_id =:val')
        ->setParameter('val', $id)
        ->orderBy('c.broker_id', 'ASC')
        ->getQuery()
        ->getResult();
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
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC');      

        return (new Paginator($qb))->paginate($page);
    }

}
