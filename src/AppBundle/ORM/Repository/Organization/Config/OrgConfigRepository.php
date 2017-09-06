<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:03 AM
 */

namespace AppBundle\ORM\Repository\Organization\Config;


use AppBundle\ORM\Entity\Organization\Organization;
use Doctrine\ORM\EntityRepository;

class OrgConfigRepository extends EntityRepository
{
    public function findAllOrderedByVariable()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('org_config', 'o')
            ->orderBy('o.variable', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganization(Organization $org)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('org_config', 'o')
            ->where('o.organization_id = :identifier')
            ->orderBy('o.variable', 'ASC')
            ->setParameter('identifier', $org->getId());
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('org_config', 'o')
            ->where('o.id = :identifier')
            ->orderBy('o.variable', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findByVariable($variable)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('org_config', 'o')
            ->where('o.variable = :identifier')
            ->orderBy('o.variable', 'ASC')
            ->setParameter('identifier', $variable);
        return $qb->getQuery()->getResult();
    }
}