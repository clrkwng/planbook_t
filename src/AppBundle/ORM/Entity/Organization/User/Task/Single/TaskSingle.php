<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:29 PM
 */

namespace AppBundle\ORM\Entity\Organization\User\Task\Single;
use AppBundle\ORM\Entity\Organization\User\Task\Common\Priority;
use AppBundle\ORM\Entity\Organization\User\Task\Task;


/**
 * @Entity(repositoryClass="TaskSingleRepository") @Table(name="task_single")
 *
 * Definition for a task that occurs only once
 *
 **/
class TaskSingle
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var Task
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Task",
     *     inversedBy="singleTasks"
     * )
     *
     * @label('Base task to inherit from')
     *
     */
    protected $task = null;

    /**
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Common\Priority",
     *     inversedBy="singleTasks"
     * )
     * @var Priority
     *
     */
    protected $priority = null;

    /**
     * @var string
     * @Column(type="string")
     *
     * UNIX timestamp for when the task must be completed by
     *
     */
    protected $deadline;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, this will override the name specified in the associated base task
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, this will override the description specified in the associated base task
     *
     */
    protected $description_ov;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\ORM\Util\Organization\User\Task\Single\TaskSingleUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
     *
     */
    protected $state;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTaskId($task)
    {
        $this->task = $task;
    }

    /**
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param Priority $priority
     */
    public function setPriority(Priority $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param string $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return string
     */
    public function getNameOv()
    {
        return $this->name_ov;
    }

    /**
     * @param string $name_ov
     */
    public function setNameOv($name_ov)
    {
        $this->name_ov = $name_ov;
    }

    /**
     * @return string
     */
    public function getDescriptionOv()
    {
        return $this->description_ov;
    }

    /**
     * @param string $description_ov
     */
    public function setDescriptionOv($description_ov)
    {
        $this->description_ov = $description_ov;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }


}