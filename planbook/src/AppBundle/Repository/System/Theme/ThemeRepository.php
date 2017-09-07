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

    public function findThemeByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Theme', 't')
            ->where('t.name = :identifier')
            ->orderBy('t.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findAllByState($state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('Theme', 't')
            ->where('t.state = :identifier')
            ->orderBy('t.state', 'ASC')
            ->setParameter('identifier', $state);
        return $qb->getQuery()->getResult();
    }
}