<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:29 PM
 */

namespace AppBundle\ORM\Entity;


/**
 * @Entity @Table(name="task_single")
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
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Base task to inherit from
     *
     */
    protected $task_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Task's priority
     *
     */
    protected $priority_id;

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
     * @Enum({"NOT_VIEWED", "IN_PROGRESS", "COMPLETED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "NOT_VIEWED"     = User is prompted with a notification
     * "IN_PROGRESS"    = User can view in their task dashboard; User can mark as complete
     * "COMPLETED"      = User can view in their task dashboard; User can not mark as complete; Points have been added
     * "DISABLED"       = Hidden from user's display; Admin can see the task, edit, and toggle the task's visibility
     * "DELETED"        = Hidden from both the user and the admin's display
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
     * @return int
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * @param int $task_id
     */
    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;
    }

    /**
     * @return int
     */
    public function getPriorityId()
    {
        return $this->priority_id;
    }

    /**
     * @param int $priority_id
     */
    public function setPriorityId($priority_id)
    {
        $this->priority_id = $priority_id;
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