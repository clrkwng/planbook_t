<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/7/2017
 * Time: 4:22 PM
 */

namespace AppBundle\Rest\Response;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class OrgTrophyResponse
{

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $orgSlug;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $orgId;

    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "trophies")
     */
    protected $trophies;

    public function __construct($orgSlug, $orgId, $trophies)
    {
        if (is_array($trophies)) {
            $trophies = new ArrayCollection($trophies);
        } elseif (!$trophies instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }
        $this->trophies = $trophies;
        $this->orgId = $orgId;
        $this->orgSlug = $orgSlug;
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
    public function getOrgId()
    {
        return $this->orgId;
    }


    /**
     * @return Collection
     */
    public function getTrophies()
    {
        return $this->trophies;
    }


}