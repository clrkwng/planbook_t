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

class TrophyResponse
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
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $trophyId;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $trophyName;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $trophyImage;


    public function __construct($orgSlug, $orgId, $trophyId, $trophyName, $trophyImage)
    {

        $this->trophyImage = $trophyImage;
        $this->orgId = $orgId;
        $this->trophyId = $trophyId;
        $this->trophyName = $trophyName;
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
     * @return int
     */
    public function getTrophyId()
    {
        return $this->trophyId;
    }

    /**
     * @return int
     */
    public function getTrophyName()
    {
        return $this->trophyName;
    }

    /**
     * @return int
     */
    public function getTrophyImage()
    {
        return $this->trophyImage;
    }


}