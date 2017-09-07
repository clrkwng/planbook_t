<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 7:15 PM
 */

namespace AppBundle\ORM\Repository\System\Theme;

use Doctrine\ORM\EntityRepository;

class ColorRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('Color', 'c')
            ->orderBy('c.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findColorByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('Color', 'c')
            ->where('c.name = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $name);
        return $qb->getQuery()->getResult();
    }

    public function findColorByHexValue($hexValue)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('Color', 'c')
            ->where('c.hex_value = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $hexValue);
        return $qb->getQuery()->getResult();
    }

    public function findAllColorsByState($state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('Color', 'c')
            ->where('c.state = :identifier')
            ->orderBy('c.name', 'ASC')
            ->setParameter('identifier', $state);
        return $qb->getQuery()->getResult();
    }
}