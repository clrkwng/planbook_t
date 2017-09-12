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
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\Config\ImageRepository")
 *
 * Per tenant container of uploaded images
 *
 **/
class Image
{
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
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload an image file.")
     * @Assert\File(
     *     mimeTypes={
     *          "image/jpeg",
     *          "image/pjpeg",
     *          "image/png"
     *     })
     */
    protected $picture;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\Config\ImageUtil",
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
     * Image constructor.
     */
    public function __construct()
    {
        $this->trophies = new ArrayCollection();
        $this->prizes = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * @param Trophy $trophy
     */
    public function addTrophy(Trophy $trophy)
    {
        $this->trophies[] = $trophy;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getTrophies(){
        return $this->trophies;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
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
     */
    public function addPrize(Prize $prize)
    {
        $this->prizes[] = $prize;
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
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
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