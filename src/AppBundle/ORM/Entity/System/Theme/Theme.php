<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:57 PM
 */

namespace AppBundle\ORM\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="theme")
 *
 *  Container of related colors
 *
 **/
class Theme
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Theme is active and can be chosen for use by Users
     * "DISABLED"           = Admin has opted to turn off this Theme for their organization; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this theme entirely
     *
     */
    protected $state;

    /**
     * @OneToMany(targetEntity="User", mappedBy="theme")
     * @var User[] An ArrayCollection of User objects.
     *
     */
    protected $users = null;

    /**
     * @OneToMany(targetEntity="ThemeColor", mappedBy="theme")
     * @var ThemeColor[] An ArrayCollection of ThemeColor objects.
     * @label('Collection of colors associated with the Theme')
     */
    protected $colors = null;

    /**
     * Theme constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->colors = new ArrayCollection();
    }

    /**
     * @param ThemeColor $color
     */
    public function addColor(ThemeColor $color)
    {
        $this->colors[] = $color;
    }

    /**
     * @return ThemeColor[]|ArrayCollection
     */
    public function getColors()
    {
        return $this->colors;
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