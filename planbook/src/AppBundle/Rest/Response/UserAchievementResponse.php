<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/7/2017
 * Time: 4:20 PM
 */

namespace AppBundle\Rest\Response;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UserAchievementResponse
{

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $userId;

    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "achievements")
     */
    protected $achievements;

    public function __construct($userId, $achievements)
    {
        if (is_array($achievements)) {
            $achievements = new ArrayCollection($achievements);
        } elseif (!$achievements instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }
        $this->achievements = $achievements;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return Collection
     */
    public function getAchievements()
    {
        return $this->achievements;
    }



}