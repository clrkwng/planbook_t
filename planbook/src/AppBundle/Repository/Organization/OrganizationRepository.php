<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:03 AM
 */

namespace AppBundle\Repository\Organization;

use Doctrine\ORM\EntityRepository;

class OrganizationRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Organization', 'o')
            ->orderBy('o.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Organization', 'o')
            ->where('o.name = :identifier')
            ->orderBy('o.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Organization', 'o')
            ->where('o.id = :identifier')
            ->orderBy('o.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findBySlug($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Organization', 'o')
            ->where('o.slug = :identifier')
            ->orderBy('o.name', 'ASC')
            ->setParameter('identifier', $slug);
        return $qb->getQuery()->getResult();
    }

    public function findByUUID($uuid)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Organization', 'o')
            ->where('o.uuid = :identifier')
            ->orderBy('o.name', 'ASC')
            ->setParameter('identifier', $uuid);
        return $qb->getQuery()->getResult();
    }
}