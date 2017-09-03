<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:54 PM
 */

namespace AppBundle\ORM\Entity\Organization\User\Task\Common;
use AppBundle\ORM\Entity\Organization\Organization;
use AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeat;
use AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeatSingle;
use AppBundle\ORM\Entity\Organization\User\Task\Single\TaskSingle;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="PriorityRepository") @Table(name="priority")
 *
 * @label('Per tenant definitions of the priority placed on user tasks')
 *
 **/
class Priority
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var Organization
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Organization",
     *     inversedBy="priorities"
     * )
     *
     * @label('Allows for the organization to define their own custom priorities with associated values')
     *
     */
    protected $organization = null;

    /**
     * @var TaskSingle
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Single\TaskSingle",
     *     mappedBy="priority"
     * )
     *
     * @label('Collection of Single Tasks of this Priority')
     *
     */
    protected $singleTasks = null;

    /**
     * @var TaskRepeat
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeat",
     *     mappedBy="priority"
     * )
     *
     * @label('Collection of Repeat Tasks of this Priority')
     *
     */
    protected $repeatTasks = null;

    /**
     * @var TaskRepeatSingle
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeatSingle",
     *     mappedBy="priority_ov"
     * )
     *
     * @label('Collection of Repeat Task Instances of this Priority')
     *
     */
    protected $repeatTaskInstances = null;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @label('How many points are given to the user upon completion of the task')
     *
     */
    protected $completion_points;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\ORM\Util\Organization\User\Task\Common\PriorityUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
     *
     *
     */
    protected $state;

    /**
     * Priority constructor.
     */
    public function __construct()
    {
        $this->singleTasks = new ArrayCollection();
        $this->repeatTasks = new ArrayCollection();
        $this->repeatTaskInstances = new ArrayCollection();

    }

    /**
     * @return TaskRepeatSingle|ArrayCollection
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
     * @return TaskSingle|ArrayCollection
     */
    public function getSingleTasks()
    {
        return $this->singleTasks;
    }

    /**
     * @param TaskSingle $singleTask
     */
    public function addSingleTask(TaskSingle $singleTask)
    {
        $this->singleTasks[] = $singleTask;
    }

    /**
     * @return TaskRepeat|ArrayCollection
     */
    public function getRepeatTasks()
    {
        return $this->repeatTasks;
    }

    /**
     * @param TaskRepeat $repeatTask
     */
    public function addRepeatTask(TaskRepeat $repeatTask)
    {
        $this->repeatTasks[] = $repeatTask;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return int
     */
    public function getCompletionPoints()
    {
        return $this->completion_points;
    }

    /**
     * @param int $completion_points
     */
    public function setCompletionPoints($completion_points)
    {
        $this->completion_points = $completion_points;
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