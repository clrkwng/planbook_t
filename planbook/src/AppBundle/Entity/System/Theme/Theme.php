<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:57 PM
 */

namespace AppBundle\Entity\System\Theme;
use AppBundle\Entity\Organization\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity(repositoryClass="ThemeRepository") @Table(name="theme")
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
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\System\Theme\ThemeUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
     *
     *
     */
    protected $state;

    /**
     * @OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     mappedBy="theme"
     * )
     * @var User[] An ArrayCollection of User objects.
     *
     */
    protected $users = null;

    /**
     * @ManyToMany(targetEntity="Color", cascade={"persist"})
     * @JoinTable(
     *      name="map_theme_color",
     *      joinColumns={
     *          @JoinColumn(
     *              name="theme_id",
     *              referencedColumnName="id"
     *          )
     *      },
     *      inverseJoinColumns={
     *          @JoinColumn(
     *              name="color_id",
     *              referencedColumnName="id"
     *          )
     *      }
     * )
     * @var Color[] An ArrayCollection of Color objects.
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
     * @param Color $color
     */
    public function addColor(Color $color)
    {
        $this->colors[] = $color;
    }

    /**
     * @return Color[]|ArrayCollection
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