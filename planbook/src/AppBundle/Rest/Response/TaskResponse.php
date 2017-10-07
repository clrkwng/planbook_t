<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/7/2017
 * Time: 4:18 PM
 */

namespace AppBundle\Rest\Response;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TaskResponse
{

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $userId;

    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "single_tasks")
     */
    protected $singleTasks;

    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "repeat_tasks")
     */
    protected $repeatTasks;

    public function __construct($userId, $singleTasks, $repeatTasks)
    {
        if (is_array($singleTasks)) {
            $singleTasks = new ArrayCollection($singleTasks);
        } elseif (!$singleTasks instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }
        if (is_array($repeatTasks)) {
            $repeatTasks = new ArrayCollection($repeatTasks);
        } elseif (!$repeatTasks instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }
        $this->repeatTasks = $repeatTasks;
        $this->singleTasks = $singleTasks;
        $this->userId = $userId;
    }

    public function getSingleTasks(){
        return $this->singleTasks;
    }
    public function getRepeatTasks(){
        return $this->repeatTasks;
    }
    public function getUserId(){
        return $this->userId;
    }


}