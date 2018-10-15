<?php

namespace App\Repository\Institution;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\User\User;
use App\Entity\Institution\Institution;
use App\Repository\Core\AbstractRepository;
/**
 * @method Institution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Institution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Institution[]    findAll()
 * @method Institution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Institution::class);
    }
    
    /**
     * Add parent to andX pattern
     * 
     * @return Expr
     */
    protected function addParentToAndXPattern($qb, $andX, $parent){
        return $andX;
    }
    
    /**
     * Same institution
     */
    public function findByUser(User $user): ?Institution {
        
        $qb = $this->createQueryBuilder('e');

           $qb
            ->addSelect('a')
            ->addSelect('m')
            ->innerJoin('e.admin', 'a')
            ->innerJoin('e.members', 'm')
            ->where(':member MEMBER OF e.members')
            ->setParameter('member', $user)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
