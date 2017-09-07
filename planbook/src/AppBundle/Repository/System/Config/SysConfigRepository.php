<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 7:15 PM
 */

namespace AppBundle\Repository\System\Config;

use Doctrine\ORM\EntityRepository;

class SysConfigRepository extends EntityRepository
{
    public function findAllOrderedByVariable()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('sys_config', 's')
            ->orderBy('s.variable', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findByVariable($variable)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('sys_config', 's')
            ->where('s.variable = :identifier')
            ->orderBy('s.variable', 'ASC')
            ->setParameter('identifier', $variable);
        return $qb->getQuery()->getResult();
    }
}