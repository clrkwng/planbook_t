<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:06 AM
 */

namespace AppBundle\Repository\Organization\User\Task\Repeat;

use Doctrine\ORM\EntityRepository;

class FrequencyRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency', 'f')
            ->orderBy('f.id', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency', 'f')
            ->where('f.name = :identifier')
            ->orderBy('f.id', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findAllByState($state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency', 'f')
            ->where('f.state = :identifier')
            ->orderBy('f.id', 'ASC')
            ->setParameter('identifier', $state);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency', 'f')
            ->where('f.id = :identifier')
            ->orderBy('f.id', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }
}