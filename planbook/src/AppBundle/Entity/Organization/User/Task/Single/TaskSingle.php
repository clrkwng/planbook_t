<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:29 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Single;

use AppBundle\Entity\Organization\User\Task\Common\Priority;
use AppBundle\Entity\Organization\User\Task\Task;
use AppBundle\Repository\Organization\User\Task\Single\TaskSingleRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="task_single")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\Task\Single\TaskSingleRepository")
 *
 * Definition for a task that occurs only once
 *
 **/
class TaskSingle
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
     *     inversedBy="singleTasks"
     * )
     *
     * Base task to inherit from
     *
     */
    protected $task = null;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Common\Priority",
     *     inversedBy="singleTasks"
     * )
     * @var Priority
     *
     */
    protected $priority = null;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * UNIX timestamp for when the task must be completed by
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 4)
     *
     */
    protected $deadline;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     *
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
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\User\Task\Single\TaskSingleUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
     *
     */
    protected $state;

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


}