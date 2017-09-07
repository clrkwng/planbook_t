<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:03 AM
 */

namespace AppBundle\Repository\Organization\Config;

use AppBundle\Entity\Organization\Organization;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{
    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from('Image', 'i')
            ->where('i.id= :identifier')
            ->orderBy('i.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findAllByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from('Image', 'i')
            ->where('i.name= :identifier')
            ->orderBy('i.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganization(Organization $org)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from('Image', 'i')
            ->where('i.organization_id= :identifier')
            ->orderBy('i.name', 'ASC')
            ->setParameter('identifier', $org->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganizationWithState(Organization $org, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from('Image', 'i')
            ->where('i.organization_id= :org_identifier')
            ->where('i.state= :state_identifier')
            ->orderBy('i.name', 'ASC')
            ->setParameter('org_identifier', $org->getId())
            ->setParameter('state_identifier', $state);
        return $qb->getQuery()->getResult();
    }

}