<?php

namespace SiteBundle\Entity\Repository;

/**
 * BannerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BannerRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function listarTodos($limite = null){
        $qb = $this->createQueryBuilder('b')
                ->select('b')
                ->distinct()
                ->addOrderBy('b.dataCadastro', 'DESC');
        
        if(false == is_null($limite)){
            $qb->setMaxResults($limite);
        }
        
        return $qb->getQuery()->getResult();
        
    }
    
}
