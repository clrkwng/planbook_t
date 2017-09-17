<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:04 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Repeat;

use AppBundle\Entity\Organization\User\Task\Common\Priority;
use AppBundle\Repository\Organization\User\Task\Repeat\TaskRepeatSingleRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="task_repeat_single")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\Task\Repeat\TaskRepeatSingleRepository")
 *
 * A single occurrence of a task that occurs on a recurrent basis
 *
 **/
class TaskRepeatSingle
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var TaskRepeat
     * @ORM\ManyToOne(targetEntity="TaskRepeat", inversedBy="repeatTaskInstances")
     *
     * Base repeat task to inherit from
     *
     */
    protected $baseRepeatTask;

    /**
     * @var Priority
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Common\Priority",
     *     inversedBy="repeatTaskInstances"
     * )
     *
     *
     *  If provided, will override the priority defined in the corresponding
     *    `Task_Repeat` record for this instance
     *
     *
     */
    protected $priority_ov;

    /**
     * @var \datetime
     * @ORM\Column(type="datetime")
     *
     * UNIX timestamp for when the task must be completed by
     *
     * @Assert\NotBlank()
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
     *    If provided, will override the name defined in the corresponding
     *     `Task_Repeat` record for this instance
     *
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
     *
     *     If provided, will override the description defined in the corresponding
     *     `Task_Repeat` record for this instance
     *
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
     * @return \datetime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param \datetime $deadline
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
        $retStr = 'TaskRepeatSingle';
        if(!is_null($this->getNameOv()) && $this->getNameOv() != ""){
            $retStr = $this->getNameOv();
        }
        return (string) $retStr;
    }

}