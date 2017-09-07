<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:03 AM
 */

namespace AppBundle\ORM\Repository\Organization\Config;


use AppBundle\ORM\Entity\Organization\Config\Image;
use AppBundle\ORM\Entity\Organization\Organization;
use Doctrine\ORM\EntityRepository;

class TrophyRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->orderBy('t.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganization(Organization $org)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->where('t.organization_id = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $org->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByImage(Image $image)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->where('t.image_id = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $image->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganizationWithState(Organization $org, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->where('t.organization_id = :org_identifier')
            ->where('t.state = :state_identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('org_identifier', $org->getId())
            ->setParameter('state_identifier', $state);
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganizationWithImage(Organization $org, Image $image)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->where('t.organization_id = :org_identifier')
            ->where('t.image_id = :image_identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('org_identifier', $org->getId())
            ->setParameter('image_identifier', $image->getId());
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->where('t.id= :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Trophy', 't')
            ->where('t.name= :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }
}