<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:07 AM
 */

namespace AppBundle\ORM\Repository\Organization\User\Task\Repeat;


use AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeat;
use Doctrine\ORM\EntityRepository;

class TaskRepeatSingleRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_repeat_single', 't')
            ->orderBy('t.id', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByTaskRepeat(TaskRepeat $baseRepeatTask)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_repeat_single', 't')
            ->where('t.baseRepeatTask_id = :identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('identifier', $baseRepeatTask->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByTaskRepeatWithState(TaskRepeat $baseRepeatTask, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_repeat_single', 't')
            ->where('t.baseRepeatTask_id = :task_repeat_identifier')
            ->where('t.baseRepeatTask_id = :state_identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('task_repeat_identifier', $baseRepeatTask->getId())
            ->setParameter('state_identifier', $state);
        return $qb->getQuery()->getResult();
    }
}