<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:07 AM
 */

namespace AppBundle\ORM\Repository\Organization\User\Task\Single;


use AppBundle\ORM\Entity\Organization\User\Task\Common\Priority;
use AppBundle\ORM\Entity\Organization\User\Task\Task;
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

    public function findAllByTaskWithState(Task $task, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_single', 't')
            ->where('t.task_id = :task_identifier')
            ->where('t.state = :state_identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('task_identifier', $task->getId())
            ->setParameter('state_identifier', $state);
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

    public function findAllByPriorityWithState(Priority $priority, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_single', 't')
            ->where('t.priority_id = :priority_identifier')
            ->where('t.state = :state_identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('priority_identifier', $priority->getId())
            ->setParameter('state_identifier', $state);
        return $qb->getQuery()->getResult();
    }
}