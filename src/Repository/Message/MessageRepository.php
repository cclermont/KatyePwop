<?php

namespace App\Repository\Message;

use Pagerfanta\Pagerfanta;
use Doctrine\ORM\Query\Expr\Join;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\User\User;
use App\Entity\Message\Message;
use App\Entity\Institution\Institution;
use App\Repository\Core\AbstractRepository;
/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
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
     * Find received message
     */
    public function findReceivedByUser(User $user, array $order = array(), $page = null, $limit = null) {
        
        $qb = $this->createQueryBuilder('e');

        $qb->where($qb->expr()->isNull('e.id'));

        if ($user->getProfile() && $location = $user->getProfile()->getLocation()) {
            $qb->where(':location MEMBER OF e.locations')
                ->andWhere($qb->expr()->eq('e.broadcasted', 1))
                ->setParameter('location', $location);
        }

        
        foreach($order as $key => $value){
            $qb->addOrderBy("e.$key", $value);
        }

        $paginator = new Pagerfanta(new DoctrineORMAdapter($qb->getQuery(), false));

        if ($page > 0) {
            $paginator->setCurrentPage($page);
        }

        if ($limit > 0) {
            $paginator->setMaxPerPage($limit);
        }


        return $paginator;
    }
    
    /**
     * Find received message
     */
    public function findReceivedByInstitution(Institution $receiver, array $order = array(), $page = null, $limit = null) {
        
        $qb = $this->createQueryBuilder('e');
        
        $orX = $qb->expr()->orX(':receiver MEMBER OF e.receivers');

        foreach ($receiver->getLocations() as $key => $item) {
            $orX->add(":location_$key MEMBER OF e.locations");
            $qb->setParameter("location_$key", $item);
        }

        $qb->where($orX)
            ->andWhere($qb->expr()->eq('e.broadcasted', 0))
            ->setParameter('receiver', $receiver)
        ;
        
        foreach($order as $key => $value){
            $qb->addOrderBy("e.$key", $value);
        }

        $paginator = new Pagerfanta(new DoctrineORMAdapter($qb->getQuery(), false));

        if ($page > 0) {
            $paginator->setCurrentPage($page);
        }

        if ($limit > 0) {
            $paginator->setMaxPerPage($limit);
        }


        return $paginator;
    }

    /**
     * Message graph
     * 
     * @return Array
     */
    public function findReceivedGraph(Institution $receiver, array $pattern = array())
    {
        // Get query builder
        $qb = $this->_em->createQueryBuilder();
        
        $orX = $qb->expr()->orX(':receiver MEMBER OF e.receivers');

        foreach ($receiver->getLocations() as $key => $item) {
            $orX->add(":location_$key MEMBER OF e.locations");
            $qb->setParameter("location_$key", $item);
        }

        // Build query
        $qb->select('COUNT(e.id) stat_count')
            ->from($this->_entityName, 'e')
            ->groupBy('stat_date')
            ->orderBy('stat_date', 'ASC')
            ->where($orX)
            ->setParameter('receiver', $receiver)
        ;
        
        // Get pattern
        $qb = $this->datePattern($qb, $pattern);

        // Return array of result
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Message graph
     * 
     * @return Array
     */
    public function allGraph(array $pattern = array())
    {
        // Get query builder
        $qb = $this->_em->createQueryBuilder();
        
        // Build query
        $qb->select('COUNT(e.id) stat_count')
            ->from($this->_entityName, 'e')
            ->groupBy('stat_date')
            ->orderBy('stat_date', 'ASC')
            ->where($qb->expr()->isNotNull('e.id'))
        ;
        
        // Get pattern
        $qb = $this->datePattern($qb, $pattern);

        // Return array of result
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Date pattern
     * 
     * @return $qb
     */
    protected function datePattern($qb, $pattern)
    {
        // Set vars
        $dateTo     = empty($pattern['date_to']) ? null : $pattern['date_to'];
        $dateFrom   = empty($pattern['date_from']) ? null : $pattern['date_from'];
        $dateSort   = empty($pattern['date_sort']) ? null : $pattern['date_sort'];

        // Sort by month, year and day
        switch ($dateSort) {
            
            case 'year':
                
                $qb->addSelect("DATE_FORMAT(e.created, '%Y') stat_date");

                // Add date from cohort
                if ($dateFrom && $dateTo) {
                    $qb->andWhere($qb->expr()->between("DATE_FORMAT(e.created, '%Y')", ':date_from', ':date_to'))
                        ->setParameter('date_to', $dateTo)
                        ->setParameter('date_from', $dateFrom);
                } else if ($dateFrom) {
                    $qb->andWhere($qb->expr()->gte("DATE_FORMAT(e.created, '%Y')", ':date_from'))
                        ->setParameter('date_from', $dateFrom);
                }

            break;

            case 'month':
                
                $qb->addSelect("DATE_FORMAT(e.created, '%Y-%m') stat_date");

                // Add date from cohort
                if ($dateFrom && $dateTo) {
                    $qb->andWhere($qb->expr()->between("DATE_FORMAT(e.created, '%Y-%m')", ':date_from', ':date_to'))
                        ->setParameter('date_to', $dateTo)
                        ->setParameter('date_from', $dateFrom);
                } else if ($dateFrom) {
                    $qb->andWhere($qb->expr()->gte("DATE_FORMAT(e.created, '%Y-%m')", ':date_from'))
                        ->setParameter('date_from', $dateFrom);
                }

            break;

            default:
                
                $qb->addSelect("DATE_FORMAT(e.created, '%Y-%m-%d') stat_date");

                // Add date from cohort
                if ($dateFrom && $dateTo) {
                    $qb->andWhere($qb->expr()->between("DATE_FORMAT(e.created, '%Y-%m-%d')", ':date_from', ':date_to'))
                        ->setParameter('date_to', $dateTo)
                        ->setParameter('date_from', $dateFrom);
                } else if ($dateFrom) {
                    $qb->andWhere($qb->expr()->gte("DATE_FORMAT(e.created, '%Y-%m-%d')", ':date_from'))
                        ->setParameter('date_from', $dateFrom);
                }

            break;
        }

        return $qb;
    }
}
