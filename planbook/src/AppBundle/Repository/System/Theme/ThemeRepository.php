<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:16 AM
 */

namespace AppBundle\Repository\System\Theme;

use Doctrine\ORM\EntityRepository;

class ThemeRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Theme', 't')
            ->orderBy('t.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Theme', 't')
            ->where('t.name = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Theme', 't')
            ->where('t.id = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findBySlug($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Theme', 't')
            ->where('t.slug = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $slug);
        return $qb->getQuery()->getResult();
    }

}