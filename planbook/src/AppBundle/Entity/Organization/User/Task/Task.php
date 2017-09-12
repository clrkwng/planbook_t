<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:03 PM
 */

namespace AppBundle\Entity\Organization\User\Task;

use AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeat;
use AppBundle\Entity\Organization\User\Task\Single\TaskSingle;
use AppBundle\Entity\Organization\User\User;
use AppBundle\Repository\Organization\User\Task\TaskRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\Task\TaskRepository")
 *
 * Base definition for a task
 *
 **/
class Task
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * User this task is assigned to
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     inversedBy="taskTemplates"
     * )
     *
     */
    protected $user = null;

    /**
     * @var TaskSingle
     *
     * Collection of single instance, child tasks
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Single\TaskSingle",
     *     mappedBy="task"
     * )
     *
     */
    protected $singleTasks = null;

    /**
     * @var TaskRepeat
     *
     * Collection of repeating, child tasks
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeat",
     *     mappedBy="task"
     * )
     *
     */
    protected $repeatTasks = null;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 2)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     *
     */
    protected $description;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\User\Task\TaskUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
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