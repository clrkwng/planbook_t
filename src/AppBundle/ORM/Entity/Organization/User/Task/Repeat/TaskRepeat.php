<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:02 PM
 */

namespace AppBundle\ORM\Entity\Organization\User\Task\Repeat;
use AppBundle\ORM\Entity\Organization\User\Task\Common\Priority;
use AppBundle\ORM\Entity\Organization\User\Task\Task;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="TaskRepeatRepository") @Table(name="task_repeat")
 *
 * @label('Definition for a task that occurs on a recurrent basis')
 *
 **/
class TaskRepeat
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
     *     inversedBy="repeatTasks"
     * )
     *
     * @label('Base task to inherit from')
     *
     */
    protected $task;

    /**
     * @var TaskRepeat[] An ArrayCollection of TaskRepeat objects.
     * @ManyToOne(targetEntity="TaskRepeat", inversedBy="baseRepeatTask")
     *
     * @label('Base task to inherit from')
     *
     */
    protected $repeatTaskInstances;

    /**
     * @var Priority
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Common\Priority",
     *     inversedBy="repeatTasks"
     * )
     *
     * @label('Task's default priority to be inherited by each single instance')
     *
     */
    protected $priority;

    /**
     * @var Frequency[] An ArrayCollection of Frequency objects.
     * @ManyToMany(targetEntity="Frequency", mappedBy="repeatTasks")
     * @label('Task's repetition frequency; used for creation of `Task_Repeat_Single`')
     *
     */
    protected $frequencies;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('If provided, this will override the name specified in the associated base task')
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('If provided, this will override the description specified in the associated base task')
     *
     */
    protected $description_ov;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * @label('
     *      "ACTIVE"             = TaskRepeat is active and actively created new single occurrences
     *      "DISABLED"           = User has opted to temporarily turn off this TaskRepeat; User can toggle back on
     *      "DELETED"            = User has chosen to delete this TaskRepeat entirely
     *     ')
     *
     */
    protected $state;

    /**
     * TaskRepeat constructor.
     */
    public function __construct()
    {
        $this->frequencies = new ArrayCollection();
        $this->repeatTaskInstances = new ArrayCollection();

    }

    /**
     * @return TaskRepeat[]|ArrayCollection
     */
    public function getRepeatTaskInstances()
    {
        return $this->repeatTaskInstances;
    }

    /**
     * @param TaskRepeatSingle $repeatTaskInstance
     */
    public function addRepeatTaskInstance(TaskRepeatSingle $repeatTaskInstance)
    {
        $this->repeatTaskInstances[] = $repeatTaskInstance;
    }

    /**
     * @return Frequency[]|ArrayCollection
     */
    public function getFrequencies()
    {
        return $this->frequencies;
    }

    /**
     * @param Frequency $frequency
     */
    public function addFrequency(Frequency $frequency)
    {
        $this->frequencies[] = $frequency;
    }

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
    public function setTask(Task $task)
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
    public function setPriority($priority)
    {
        $this->priority = $priority;
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