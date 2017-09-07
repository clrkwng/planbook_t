<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:03 AM
 */

namespace AppBundle\Repository\Organization\Config;

use Doctrine\ORM\EntityRepository;

class TypeRepository extends EntityRepository
{
    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Type', 't')
            ->where('t.id= :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Type', 't')
            ->where('t.name= :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findAllByState($state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Type', 't')
            ->where('t.state= :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $state);
        return $qb->getQuery()->getResult();
    }

    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Type', 't')
            ->orderBy('t.name', 'ASC');
        return $qb->getQuery()->getResult();
    }
}