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
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @var TaskSingle[]|ArrayCollection
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
     * @var TaskRepeat[]|ArrayCollection
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
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

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
     * @return $this
     */
    public function addSingleTask(TaskSingle $singleTask)
    {
        if (!$this->singleTasks->contains($singleTask)) {
            $this->singleTasks[] = $singleTask;
        }
        return $this;
    }

    /**
     * @return TaskSingle[]|ArrayCollection
     */
    public function getSingleTasks()
    {
        return $this->singleTasks;
    }

    /**
     * @param TaskRepeat $repeatTask
     * @return $this
     */
    public function addRepeatTask(TaskRepeat $repeatTask)
    {
        if (!$this->repeatTasks->contains($repeatTask)) {
            $this->repeatTasks[] = $repeatTask;
        }
        return $this;
    }

    /**
     * @return TaskRepeat[]|ArrayCollection
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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function __toString(){
        return $this->getName();
    }


}