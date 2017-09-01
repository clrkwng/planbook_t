<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:27 PM
 */

namespace AppBundle\ORM;
use AppBundle\ORM\Entity\Category;
use AppBundle\ORM\Entity\Image;
use AppBundle\ORM\Entity\OrgConfig;
use AppBundle\ORM\Entity\Priority;
use AppBundle\ORM\Entity\Trophy;
use AppBundle\ORM\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="organization")
 *
 * @label('Collection of users')
 *
 **/
class Organization
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @OneToMany(targetEntity="Image", mappedBy="organization")
     * @var Image[] An ArrayCollection of Image objects.
     *
     */
    protected $images = null;

    /**
     * @OneToMany(targetEntity="OrgConfig", mappedBy="organization")
     * @var OrgConfig[] An ArrayCollection of OrgConfig objects.
     *
     */
    protected $orgConfigurations = null;

    /**
     * @OneToMany(targetEntity="Trophy", mappedBy="organization")
     * @var Trophy[] An ArrayCollection of Trophy objects.
     *
     */
    protected $trophies = null;

    /**
     * @OneToMany(targetEntity="Priority", mappedBy="organization")
     * @var Priority[] An ArrayCollection of Priority objects.
     *
     */
    protected $priorities = null;

    /**
     * @OneToMany(targetEntity="User", mappedBy="organization")
     * @var User[] An ArrayCollection of User objects.
     *
     */
    protected $users = null;

    /**
     * @OneToMany(targetEntity="Category", mappedBy="organization")
     * @var Category[] An ArrayCollection of Category objects.
     *
     */
    protected $categories = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('Generated UUID that can be used to link uniquely to a particular tenant')
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