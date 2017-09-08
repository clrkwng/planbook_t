<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:04 AM
 */

namespace AppBundle\Repository\Organization\User;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\User\User;
use Doctrine\ORM\EntityRepository;

class PrizeRepository extends EntityRepository
{
    public function findAllByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('Prize', 'p')
            ->where('p.user_id = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $user->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByUserWithState(User $user, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('Prize', 'p')
            ->where('p.user_id = :user_identifier')
            ->where('p.state = :state_identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('user_identifier', $user->getId())
            ->setParameter('state_identifier', $state);
        return $qb->getQuery()->getResult();
    }

    public function findAllByImage(Image $image)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('Prize', 'p')
            ->where('p.image_id = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $image->getId());
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('Prize', 'p')
            ->where('p.name = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }
}