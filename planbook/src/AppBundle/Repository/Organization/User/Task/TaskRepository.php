<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:05 AM
 */

namespace AppBundle\Repository\Organization\User\Task;

use AppBundle\Entity\Organization\User\User;
use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task', 't')
            ->orderBy('t.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task', 't')
            ->where('t.user_id = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $user->getId());
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task', 't')
            ->where('t.name = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task', 't')
            ->where('t.id = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }
}