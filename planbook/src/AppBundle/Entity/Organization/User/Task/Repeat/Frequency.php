<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:39 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Repeat;

use AppBundle\Repository\Organization\User\Task\Repeat\FrequencyRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="frequency")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\Task\Repeat\FrequencyRepository")
 *
 * Base definition for a recurring task
 *
 * @Serializer\XmlRoot("frequency")
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
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Repeat\FrequencyMeta",
     *     mappedBy="frequency"
     * )
     * @var FrequencyMeta[] An ArrayCollection of FrequencyMeta objects.
     *
     */
    protected $metaData = null;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeat",
     *     inversedBy="frequencies"
     * )
     * @var TaskRepeat[] An ArrayCollection of TaskRepeat objects.
     *
     */
    protected $repeatTasks = null;

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
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     *
     * Allows for the frequency to be accessed via a url
     *
     */
    protected $slug;


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
     * @return ArrayCollection|null
     */
    public function getRepeatTasks()
    {
        return $this->repeatTasks;
    }

    /**
     * @param FrequencyMeta $frequencyMeta
     * @return $this
     */
    public function addMetaData(FrequencyMeta $frequencyMeta){
        if (!$this->metaData->contains($frequencyMeta)) {
            $this->metaData[] = $frequencyMeta;
        }
        return $this;
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
     *
     *
     * @return string
     */
    public function __toString(){
        $retStr = 'Frequency';
        if(!is_null($this->getName()) && $this->getName() != ""){
            $retStr = $this->getName();
        }
        return (string) $retStr;
    }

}