<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:06 AM
 */

namespace AppBundle\Repository\Organization\User\Task\Repeat;

use AppBundle\Entity\Organization\User\Task\Repeat\Frequency;
use Doctrine\ORM\EntityRepository;

class FrequencyMetaRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency_meta', 'f')
            ->orderBy('f.id', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllByFrequency(Frequency $frequency)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency_meta', 'f')
            ->where('f.frequency_id = :identifier')
            ->orderBy('f.id', 'ASC')
            ->setParameter('identifier', $frequency->getId());
        return $qb->getQuery()->getResult();
    }
    public function findByFrequencyWithMetaKey(Frequency $frequency, $metaKey)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency_meta', 'f')
            ->where('f.frequency_id = :frequency_identifier')
            ->where('f.meta_key = :key_identifier')
            ->orderBy('f.id', 'ASC')
            ->setParameter('frequency_identifier', $frequency->getId())
            ->setParameter('key_identifier', $metaKey);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('frequency_meta', 'f')
            ->where('f.id = :identifier')
            ->orderBy('f.id', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }
}