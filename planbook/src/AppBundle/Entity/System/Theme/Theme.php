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
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="ThemeRepository")
 *
 *  Container of related colors
 *
 **/
class Theme
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
     * @Assert\NotBlank()
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
     * @ORM\Column(type="string")
     *
     *
     */
    protected $state;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     mappedBy="theme"
     * )
     * @var User[] An ArrayCollection of User objects.
     *
     */
    protected $users = null;

    /**
     * @ORM\ManyToMany(targetEntity="Color", cascade={"persist"})
     * @ORM\JoinTable(
     *      name="map_theme_color",
     *      joinColumns={
     *          @ORM\JoinColumn(
     *              name="theme_id",
     *              referencedColumnName="id"
     *          )
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(
     *              name="color_id",
     *              referencedColumnName="id"
     *          )
     *      }
     * )
     * @var Color[] An ArrayCollection of Color objects.
     *
     * Collection of colors associated with the Theme
     *
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