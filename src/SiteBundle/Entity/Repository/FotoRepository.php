<?php

namespace SiteBundle\Entity\Repository;

/**
 * FotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FotoRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function listarTodos($limite = null){
        $qb = $this->createQueryBuilder('f')
                ->select('f')
                ->distinct()
                ->addOrderBy('f.dataCadastro', 'DESC');
        
        if(false == is_null($limite)){
            $qb->setMaxResults($limite);
        }
        
        return $qb->getQuery()->getResult();
        
    }
    
}
