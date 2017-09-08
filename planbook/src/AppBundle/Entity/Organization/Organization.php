<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:27 PM
 */

namespace AppBundle\Entity\Organization;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\Config\OrgConfig;
use AppBundle\Entity\Organization\Config\Trophy;
use AppBundle\Entity\Organization\User\Task\Common\Category;
use AppBundle\Entity\Organization\User\Task\Common\Priority;
use AppBundle\Entity\Organization\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="OrganizationRepository")
 *
 * Collection of users
 *
 **/
class Organization
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\Config\Image",
     *     mappedBy="organization"
     * )
     * @var Image[] An ArrayCollection of Image objects.
     *
     */
    protected $images = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\Config\OrgConfig",
     *     mappedBy="organization"
     * )
     * @var OrgConfig[] An ArrayCollection of OrgConfig objects.
     *
     */
    protected $orgConfigurations = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\Config\Trophy",
     *     mappedBy="organization"
     * )
     * @var Trophy[] An ArrayCollection of Trophy objects.
     *
     */
    protected $trophies = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Common\Priority",
     *     mappedBy="organization"
     * )
     * @var Priority[] An ArrayCollection of Priority objects.
     *
     */
    protected $priorities = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     mappedBy="organization"
     * )
     * @var User[] An ArrayCollection of User objects.
     *
     */
    protected $users = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Common\Category",
     *     mappedBy="organization"
     * )
     * @var Category[] An ArrayCollection of Category objects.
     *
     */
    protected $categories = null;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    protected $name;

    /**
     * @var uuid
     * @ORM\Column(
     *     type="guid",
     *     unique=true
     * )
     *
     * Generated UUID that can be used to link uniquely to a particular tenant
     *
     * @Assert\NotBlank()
     *
     */
    protected $uuid;

    /**
     * Organization constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->orgConfigurations = new ArrayCollection();
        $this->trophies = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->priorities = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    /**
     * @return Image[]|ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param Priority $priority
     */
    public function addPriority(Priority $priority)
    {
        $this->priorities[] = $priority;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getPriorities()
    {
        return $this->priorities;
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
     * @param Trophy $trophy
     */
    public function addTrophy(Trophy $trophy)
    {
        $this->trophies[] = $trophy;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getTrophies()
    {
        return $this->trophies;
    }

    /**
     * @param OrgConfig $orgConfig
     */
    public function addOrgConfiguration(OrgConfig $orgConfig)
    {
        $this->orgConfigurations[] = $orgConfig;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getOrgConfigurations()
    {
        return $this->orgConfigurations;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }





}