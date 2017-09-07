<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 8:15 PM
 */

namespace AppBundle\Repository\Organization\User\Task;

use AppBundle\Entity\Organization\Config\Trophy;
use AppBundle\Entity\Organization\User\User;
use Doctrine\ORM\EntityRepository;

class AchievementRepository extends EntityRepository
{
    public function findAllByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Achievements', 'a')
            ->where('a.user_id = :identifier')
            ->orderBy('a.id', 'ASC')
            ->setParameter('identifier', $user->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByTrophy(Trophy $trophy)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Achievements', 'a')
            ->where('a.trophy_id = :identifier')
            ->orderBy('a.id', 'ASC')
            ->setParameter('identifier', $trophy->getId());
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