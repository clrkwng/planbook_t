<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:03 PM
 */

namespace AppBundle\ORM\Entity\Organization\User\Task;

use AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeat;
use AppBundle\ORM\Entity\Organization\User\Task\Single\TaskSingle;
use AppBundle\ORM\Entity\Organization\User\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="TaskRepository") @Table(name="task")
 *
 * @label('Base definition for a task')
 *
 **/
class Task
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var User
     *
     * @label('User this task is assigned to')
     *
     * @ManytoOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\User",
     *     inversedBy="taskTemplates"
     * )
     *
     */
    protected $user = null;

    /**
     * @var TaskSingle
     *
     * @label('Collection of single instance, child tasks')
     *
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Single\TaskSingle",
     *     mappedBy="task"
     * )
     *
     */
    protected $singleTasks = null;

    /**
     * @var TaskRepeat
     *
     * @label('Collection of repeating, child tasks')
     *
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Repeat\TaskRepeat",
     *     mappedBy="task"
     * )
     *
     */
    protected $repeatTasks = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $description;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Task is active and available for Users to create instances of
     * "DISABLED"           = User has opted to temporarily turn off this Task; User can toggle back on
     * "DELETED"            = User has chosen to delete this Task entirely
     *
     */
    protected $state;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->singleTasks = new ArrayCollection();
        $this->repeatTasks = new ArrayCollection();

    }

    /**
     * @param TaskSingle $singleTask
     */
    public function addSingleTask(TaskSingle $singleTask)
    {
        $this->singleTasks[] = $singleTask;
    }

    /**
     * @return TaskSingle|ArrayCollection
     */
    public function getSingleTasks()
    {
        return $this->singleTasks;
    }

    /**
     * @param TaskRepeat $repeatTask
     */
    public function addRepeatTask(TaskRepeat $repeatTask)
    {
        $this->repeatTasks[] = $repeatTask;
    }

    /**
     * @return TaskRepeat|ArrayCollection
     */
    public function getRepeatTasks()
    {
        return $this->repeatTasks;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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