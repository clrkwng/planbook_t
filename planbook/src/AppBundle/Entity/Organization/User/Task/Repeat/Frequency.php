<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:39 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Repeat;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="frequency")
 * @ORM\Entity(repositoryClass="FrequencyRepository")
 *
 * Base definition for a recurring task
 *
 **/
class Frequency
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     * @ORM\Column(type="string")
     *
     *
     *  Name associated with this frequency set
     *   (ex: "Every Tuesday", "Every Day", "Every n days", etc)
     *
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 2)
     *
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="FrequencyMeta", mappedBy="frequency")
     * @var FrequencyMeta[] An ArrayCollection of FrequencyMeta objects.
     *
     */
    protected $metaData = null;

    /**
     * @ORM\ManyToMany(targetEntity="TaskRepeat", mappedBy="frequency")
     * @var TaskRepeat[] An ArrayCollection of TaskRepeat objects.
     *
     */
    protected $repeatTasks = null;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\User\Task\Repeat\FrequencyUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
     *
     */
    protected $state;

    /**
     * Frequency constructor.
     */
    public function __construct()
    {
        $this->metaData = new ArrayCollection();
        $this->repeatTasks = new ArrayCollection();

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param TaskRepeat $repeatTask
     */
    public function addRepeatTask(TaskRepeat $repeatTask)
    {
        $this->repeatTasks[] = $repeatTask;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getRepeatTasks()
    {
        return $this->repeatTasks;
    }

    /**
     * @param FrequencyMeta $frequencyMeta
     */
    public function addMetaData(FrequencyMeta $frequencyMeta){
        $this->metaData[] = $frequencyMeta;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getMetaData()
    {
        return $this->metaData;
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