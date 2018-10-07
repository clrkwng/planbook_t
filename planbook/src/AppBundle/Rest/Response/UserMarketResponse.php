<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/7/2017
 * Time: 4:19 PM
 */

namespace AppBundle\Rest\Response;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UserMarketResponse
{

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $userId;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $userPrizePoints;

    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "prizes")
     */
    protected $prizes;

    public function __construct($userId, $userPrizePoints, $prizes)
    {
        if (is_array($prizes)) {
            $prizes = new ArrayCollection($prizes);
        } elseif (!$prizes instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }
        $this->userId = $userId;
        $this->userPrizePoints = $userPrizePoints;
        $this->prizes = $prizes;
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
    public function getUserPrizePoints()
    {
        return $this->userPrizePoints;
    }

    /**
     * @return Collection
     */
    public function getPrizes()
    {
        return $this->prizes;
    }



}