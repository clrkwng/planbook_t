<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:02 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Repeat;

use AppBundle\Entity\Organization\User\Task\Common\Priority;
use AppBundle\Entity\Organization\User\Task\Task;
use AppBundle\Repository\Organization\User\Task\Repeat\TaskRepeatRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * @ORM\Table(name="task_repeat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\Task\Repeat\TaskRepeatRepository")
 *
 * Definition for a task that occurs on a recurrent basis
 *
 **/
class TaskRepeat
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Task
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Task",
     *     inversedBy="repeatTasks"
     * )
     *
     * Base task to inherit from
     *
     */
    protected $task;

    /**
     * @var TaskRepeat[] An ArrayCollection of TaskRepeat objects.
     * @ORM\OneToMany(targetEntity="TaskRepeatSingle", mappedBy="baseRepeatTask")
     *
     * Base task to inherit from
     *
     */
    protected $repeatTaskInstances;

    /**
     * @var Priority
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Common\Priority",
     *     inversedBy="repeatTasks"
     * )
     *
     * Task's default priority to be inherited by each single instance
     *
     */
    protected $priority;

    /**
     * @var Frequency[] An ArrayCollection of Frequency objects.
     * @ORM\ManyToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Repeat\Frequency",
     *     mappedBy="repeatTasks"
     * )
     * Task's repetition frequency; used for creation of `Task_Repeat_Single`
     *
     */
    protected $frequencies;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     *
     * If provided, this will override the name specified in the associated base task
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     *
     * If provided, this will override the description specified in the associated base task
     *
     */
    protected $description_ov;

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
     * @ORM\Column(length=255, unique=true)
     *
     * @Gedmo\Slug(fields={"id"}, updatable=false)
     *
     * Allows for the task repeat to be accessed via a url
     *
     */
    protected $slug;


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
     * @return $this
     */
    public function addRepeatTaskInstance(TaskRepeatSingle $repeatTaskInstance)
    {
        if (!$this->repeatTaskInstances->contains($repeatTaskInstance)) {
            $this->repeatTaskInstances[] = $repeatTaskInstance;
        }
        return $this;
    }


    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * @return $this
     */
    public function addFrequency(Frequency $frequency)
    {
        if (!$this->frequencies->contains($frequency)) {
            $this->frequencies[] = $frequency;
        }
        return $this;
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

    /**
     *
     *
     * @return string
     */
    public function __toString(){
        $retStr = 'TaskRepeat';
        if(!is_null($this->getNameOv()) && $this->getNameOv() != ""){
            $retStr = $this->getNameOv();
        }
        return (string) $retStr;
    }

}