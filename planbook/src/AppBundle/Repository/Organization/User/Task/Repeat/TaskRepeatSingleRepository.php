<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:07 AM
 */

namespace AppBundle\Repository\Organization\User\Task\Repeat;

use AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeat;
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

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_repeat_single', 't')
            ->where('t.id = :identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findBySlug($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('task_repeat_single', 't')
            ->where('t.slug = :identifier')
            ->orderBy('t.id', 'ASC')
            ->setParameter('identifier', $slug);
        return $qb->getQuery()->getResult();
    }

}