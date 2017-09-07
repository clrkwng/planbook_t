<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 11:04 AM
 */

namespace AppBundle\Repository\Organization\User\Task;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\Config\Type;
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

    public function findAllByOrganizationWithState(Organization $org, $state)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.organization_id = :org_identifier')
            ->where('u.state = :state_identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('org_identifier', $org->getId())
            ->setParameter('state_identifier', $state);
        return $qb->getQuery()->getResult();
    }

    public function findAllByOrganizationWithType(Organization $org, Type $type)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.organization_id = :org_identifier')
            ->where('u.type_id = :type_identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('org_identifier', $org->getId())
            ->setParameter('type_identifier', $type->getId());
        return $qb->getQuery()->getResult();
    }

    public function findAllByType(Type $type)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('User', 'u')
            ->where('u.type_id = :identifier')
            ->orderBy('u.username', 'ASC')
            ->setParameter('identifier', $type->getId());
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