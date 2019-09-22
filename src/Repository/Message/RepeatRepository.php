<?php

namespace App\Repository\Message;

use App\Entity\Message\Repeat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Repeat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repeat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repeat[]    findAll()
 * @method Repeat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepeatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Repeat::class);
    }

//    /**
//     * @return Repeat[] Returns an array of Repeat objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repeat
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
