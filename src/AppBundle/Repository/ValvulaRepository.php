<?php

namespace AppBundle\Repository;

/**
 * ValvulaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ValvulaRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCountValvulas(){
        $qb = $this
            ->createQueryBuilder('v')
            ->select('MAX(v.id)');
            
        return $qb->getQuery()->getSingleResult();
            
    }
}
