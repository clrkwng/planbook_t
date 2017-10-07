<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:06 AM
 */

namespace AppBundle\Repository\Organization\User\Task\Common;

use AppBundle\Entity\Organization\Organization;
use Doctrine\ORM\EntityRepository;

class PriorityRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('priority', 'p')
            ->orderBy('p.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganization(Organization $org)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('priority', 'p')
            ->where('p.organization_id = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $org->getId());
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('priority', 'p')
            ->where('p.name = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('priority', 'p')
            ->where('p.id = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findBySlug($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('priority', 'p')
            ->where('p.slug = :identifier')
            ->orderBy('p.name', 'ASC')
            ->setParameter('identifier', $slug);
        return $qb->getQuery()->getResult();
    }
}