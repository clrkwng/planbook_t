<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:05 AM
 */

namespace AppBundle\Repository\Organization\User\Task\Common;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\Organization;


use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('category', 'c')
            ->orderBy('c.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganization(Organization $org)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('category', 'c')
            ->where('c.organization_id = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $org->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByImage(Image $image)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('category', 'c')
            ->where('c.image_id = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $image->getId());
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('category', 'c')
            ->where('c.id = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findBySlug($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('category', 'c')
            ->where('c.slug = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $slug);
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('category', 'c')
            ->where('c.name = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }
}