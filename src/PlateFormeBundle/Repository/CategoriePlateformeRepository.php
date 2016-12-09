<?php

namespace PlateFormeBundle\Repository;

/**
 * CategoriePlateformeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriePlateformeRepository extends \Doctrine\ORM\EntityRepository
{
        public function getSousCategorie(){
//        $sql = 'SELECT * FROM categorie_plateforme WHERE parent_id is NOT null and actif = 1';
//        return $this->getEntityManager()->getConnection()->executeQuery($sql)->fetchAll();

            $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.parent IS NOT NULL')
            ->andWhere('a.actif = 1')
            ->add('orderBy', 'a.nom ASC');

   	    return $qb->getQuery()->getResult();

    }
}
