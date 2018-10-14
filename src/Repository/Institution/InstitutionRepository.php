<?php

namespace App\Repository\Institution;

use Symfony\Bridge\Doctrine\RegistryInterface;

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
}
