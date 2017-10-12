<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/7/2017
 * Time: 4:15 PM
 */

namespace AppBundle\Rest\Response;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class OrgUsersResponse
{

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $orgId;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $orgSlug;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $orgName;

    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "users")
     */
    protected $users;

    public function __construct($orgId, $orgSlug, $orgName, $users)
    {
        if (is_array($users)) {
            $users = new ArrayCollection($users);
        } elseif (!$users instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }
        $this->users = $users;
        $this->orgName = $orgName;
        $this->orgId = $orgId;
        $this->orgSlug = $orgSlug;
    }

    /**
     * @return int
     */
    public function getOrgId()
    {
        return $this->orgId;
    }

    /**
     * @return int
     */
    public function getOrgSlug()
    {
        return $this->orgSlug;
    }

    /**
     * @return int
     */
    public function getOrgName()
    {
        return $this->orgName;
    }

    /**
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users;
    }


}