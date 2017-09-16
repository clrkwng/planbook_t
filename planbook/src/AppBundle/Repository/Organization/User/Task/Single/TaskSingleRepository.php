<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:07 AM
 */

namespace AppBundle\Repository\Organization\User\Task\Single;

use AppBundle\Entity\Organization\User\Task\Common\Priority;
use AppBundle\Entity\Organization\User\Task\Task;
use Doctrine\ORM\EntityRepository;

class TaskSingleRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_single', 't')
            ->orderBy('t.id', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByTask(Task $task)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_single', 't')
            ->where('t.task_id = :identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('identifier', $task->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByPriority(Priority $priority)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_single', 't')
            ->where('t.priority_id = :identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('identifier', $priority->getId());
        return $qb->getQuery()->getResult();
    }

}