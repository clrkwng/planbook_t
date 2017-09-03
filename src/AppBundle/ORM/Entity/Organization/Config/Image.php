<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:53 PM
 */

namespace AppBundle\ORM\Entity\Organization\Config;
use AppBundle\ORM\Entity\Organization\Organization;
use AppBundle\ORM\Entity\Organization\User\Prize;
use AppBundle\ORM\Entity\Organization\User\Task\Common\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Entity(repositoryClass="ImageRepository") @Table(name="image")
 *
 * @label('Per tenant container of uploaded images')
 *
 **/
class Image
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var Organization
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Organization",
     *     inversedBy="images"
     * )
     *
     * @label('Allows for an organization to build up and manage their own repository of uploaded images')
     *
     */
    protected $organization = null;

    /**
     * @OneToMany(targetEntity="Trophy", mappedBy="image")
     * @var Trophy[] An ArrayCollection of Trophy objects.
     *
     */
    protected $trophies = null;

    /**
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Common\Category",
     *     mappedBy="image"
     * )
     * @var Category[] An ArrayCollection of Category objects.
     *
     */
    protected $categories = null;

    /**
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Prize",
     *     mappedBy="image"
     * )
     * @var Prize[] An ArrayCollection of Prize objects.
     *
     */
    protected $prizes = null;

    /**
     * @var string
     * @Column(type="string")
     *
     * @Assert\NotBlank
     * @Assert\Length(min = 2)
     */
    protected $name;

    /**
     * @var string
     * @Column(
     *     type="string",
     *     nullable=true
     * )
     */
    protected $description;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $link;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\ORM\Util\Organization\Config\ImageUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
     *
     */
    protected $state;

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
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