<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 8:15 PM
 */

namespace AppBundle\ORM\Repository\Organization\User\Task;


use Doctrine\ORM\EntityRepository;

class AchievementRepository extends EntityRepository
{
    public function findAllByUserId($userId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Achievements', 'a')
            ->where('a.user_id = :identifier')
            ->orderBy('a.id', 'ASC')
            ->setParameter('identifier', $userId);
        return $qb->getQuery()->getResult();
    }

    public function findAllByTrophyId($trophyId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Achievements', 'a')
            ->where('a.trophy_id = :identifier')
            ->orderBy('a.id', 'ASC')
            ->setParameter('identifier', $trophyId);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Achievements', 'a')
            ->where('a.id = :identifier')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

}