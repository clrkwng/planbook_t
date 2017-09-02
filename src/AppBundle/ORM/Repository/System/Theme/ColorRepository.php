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
    public function findColorsByThemeId($themeId, $number = 10)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->join('p.platform', 'f')
            ->where($qb->expr()->eq('f.id', $id));
        return $qb;
    }
}