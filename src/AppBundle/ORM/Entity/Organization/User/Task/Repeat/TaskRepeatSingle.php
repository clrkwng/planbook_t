<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:04 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="task_repeat_single")
 *
 * A single occurrence of a task that occurs on a recurrent basis
 *
 **/
class TaskRepeatSingle
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
     * Base repeat task to inherit from
     *
     */
    protected $task_repeat_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * If provided, will override the priority defined in the corresponding `Task_Repeat` record for this instance
     *
     */
    protected $priority_id_ov;

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
     * If provided, will override the name defined in the corresponding `Task_Repeat` record for this instance
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, will override the description defined in the corresponding `Task_Repeat` record for this instance
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
    public function getTaskRepeatId()
    {
        return $this->task_repeat_id;
    }

    /**
     * @param int $task_repeat_id
     */
    public function setTaskRepeatId($task_repeat_id)
    {
        $this->task_repeat_id = $task_repeat_id;
    }

    /**
     * @return int
     */
    public function getPriorityIdOv()
    {
        return $this->priority_id_ov;
    }

    /**
     * @param int $priority_id_ov
     */
    public function setPriorityIdOv($priority_id_ov)
    {
        $this->priority_id_ov = $priority_id_ov;
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