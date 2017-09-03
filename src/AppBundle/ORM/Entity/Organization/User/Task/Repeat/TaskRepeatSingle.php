<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:04 PM
 */

namespace AppBundle\ORM\Entity\Organization\User\Task\Repeat;
use AppBundle\ORM\Entity\Organization\User\Task\Common\Priority;

/**
 * @Entity(repositoryClass="TaskRepeatSingleRepository") @Table(name="task_repeat_single")
 *
 * @label('A single occurrence of a task that occurs on a recurrent basis')
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
     * @var TaskRepeat
     * @ManyToOne(targetEntity="TaskRepeat", inversedBy="repeatTaskInstances")
     *
     * @label('Base repeat task to inherit from')
     *
     */
    protected $baseRepeatTask;

    /**
     * @var Priority
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Common\Priority",
     *     inversedBy="repeatTasks"
     * )
     *
     * @label('
     *     If provided, will override the priority defined in the corresponding
     *      `Task_Repeat` record for this instance
     *     ')
     *
     */
    protected $priority_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('UNIX timestamp for when the task must be completed by')
     *
     */
    protected $deadline;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('
     *        If provided, will override the name defined in the corresponding
     *        `Task_Repeat` record for this instance
     *     ')
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('
     *     If provided, will override the description defined in the corresponding
     *     `Task_Repeat` record for this instance
     *     ')
     *
     */
    protected $description_ov;

    /**
     * @var string
     * @Enum({"NOT_VIEWED", "IN_PROGRESS", "COMPLETED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * @label('
     *      "NOT_VIEWED"     = User is prompted with a notification
     *      "IN_PROGRESS"    = User can view in their task dashboard; User can mark as complete
     *      "COMPLETED"      = User can view in their task dashboard; User can not mark as complete; Points have been added
     *      "DISABLED"       = Hidden from user's display; Admin can see the task, edit, and toggle the task's visibility
     *      "DELETED"        = Hidden from both the user and the admin's display
     *     ')
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
     * @return TaskRepeat
     */
    public function getBaseTaskRepeat()
    {
        return $this->baseRepeatTask;
    }

    /**
     * @param TaskRepeat $repeatTask
     */
    public function setTaskRepeatId(TaskRepeat $repeatTask)
    {
        $this->baseRepeatTask = $repeatTask;
    }

    /**
     * @return Priority
     */
    public function getPriorityOv()
    {
        return $this->priority_ov;
    }

    /**
     * @param Priority $priority_ov
     */
    public function setPriorityIdOv(Priority $priority_ov)
    {
        $this->priority_ov = $priority_ov;
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