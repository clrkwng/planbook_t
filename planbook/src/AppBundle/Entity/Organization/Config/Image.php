<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:53 PM
 */

namespace AppBundle\Entity\Organization\Config;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Entity\Organization\User\Prize;
use AppBundle\Entity\Organization\User\Task\Common\Category;
use AppBundle\Repository\Organization\Config\ImageRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\Config\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 * Per tenant container of uploaded images
 *
 **/
class Image
{

    const SERVER_PATH_TO_IMAGE_FOLDER = 'C:/Temp/Planbook/ImageUpload';

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Organization
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Organization",
     *     inversedBy="images"
     * )
     *
     * Allows for an organization to build up and manage their own repository of uploaded images
     *
     */
    protected $organization = null;

    /**
     * @ORM\OneToMany(targetEntity="Trophy", mappedBy="image")
     * @var Trophy[] An ArrayCollection of Trophy objects.
     *
     */
    protected $trophies = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Common\Category",
     *     mappedBy="image"
     * )
     * @var Category[] An ArrayCollection of Category objects.
     *
     */
    protected $categories = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Prize",
     *     mappedBy="image"
     * )
     * @var Prize[] An ArrayCollection of Prize objects.
     *
     */
    protected $prizes = null;

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
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     *
     */
    protected $fileName;

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
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
     * Allows for the image to be accessed via a url
     *
     */
    protected $slug;

    /**
     * Image constructor.
     */
    public function __construct()
    {

        $this->trophies = new ArrayCollection();
        $this->prizes = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->fileName = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     *
     * Returns the Web path where this image is saved on (used for displaying an image preview)
     *
     * @return string
     */
    public function getWebPath(){
        return self::SERVER_PATH_TO_IMAGE_FOLDER . '/' .$this->fileName;
    }

    /**
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdatedAt(new \DateTime());
    }


    /**
     * @param Trophy $trophy
     * @return $this
     */
    public function addTrophy(Trophy $trophy)
    {
        if (!$this->trophies->contains($trophy)) {
            $this->trophies[] = $trophy;
        }
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getTrophies(){
        return $this->trophies;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Prize $prize
     * @return $this
     */
    public function addPrize(Prize $prize)
    {
        if (!$this->prizes->contains($prize)) {
            $this->prizes[] = $prize;
        }
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getPrizes()
    {
        return $this->prizes;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
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
        $retStr = 'Image';
        if(!is_null($this->getName()) && $this->getName() != ""){
            $retStr = $this->getName();
        }
        return (string) $retStr;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


}