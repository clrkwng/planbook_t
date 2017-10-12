<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/7/2017
 * Time: 4:16 PM
 */

namespace AppBundle\Rest\Response;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UserProfileResponse
{

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $username;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $userId;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $userImage;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $totalPoints;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $prizePoints;


    public function __construct($username, $userId, $userImage, $totalPoints, $prizePoints)
    {

        $this->username = $username;
        $this->userId = $userId;
        $this->userImage = $userImage;
        $this->totalPoints = $totalPoints;
        $this->prizePoints = $prizePoints;
    }

    /**
     * @return int
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getUserImage()
    {
        return $this->userImage;
    }

    /**
     * @return int
     */
    public function getTotalPoints()
    {
        return $this->totalPoints;
    }

    /**
     * @return int
     */
    public function getPrizePoints()
    {
        return $this->prizePoints;
    }



}