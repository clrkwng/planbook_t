<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:04 AM
 */

namespace AppBundle\Repository\Organization\User;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Entity\System\Theme\Theme;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function findAllByOrganization(Organization $org)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.organization_id = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $org->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByTheme(Theme $theme)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.theme_id = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $theme->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByImage(Image $image)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.image_id = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $image->getId());
        return $qb->getQuery()->getResult();
    }

    public function findByUsername($username)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.username = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $username);
        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.id= :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $id);
        return $qb->getQuery()->getResult();
    }

    public function findBySlug($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.slug= :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $slug);
        return $qb->getQuery()->getResult();
    }

    public function findByUUID($uuid)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.uuid = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $uuid);
        return $qb->getQuery()->getResult();
    }

    public function findByEmail($email)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.email = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $email);
        return $qb->getQuery()->getResult();
    }
}