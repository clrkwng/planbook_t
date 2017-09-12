<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:05 PM
 */

namespace AppBundle\Entity\Organization\User;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\Config\Type;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Entity\Organization\User\Task\Task;
use AppBundle\Entity\System\Theme\Theme;
use AppBundle\Util\Organization\User\UserUtil;
use AppBundle\Repository\Organization\User\UserRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\UserRepository")
 * @ORM\Table(name="`user`")
 *
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 *
 * Account information for users on a per tenant basis
 *
 **/
class User extends BaseUser implements UserInterface, \Serializable
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Task\Task",
     *     mappedBy="user"
     * )
     * @var Task[] An ArrayCollection of Task objects.
     *
     * Base Tasks Associated with the User
     *
     */
    protected $taskTemplates = null;

    /**
     * @ORM\OneToMany(targetEntity="Prize", mappedBy="user")
     * @var Prize[] An ArrayCollection of Prize objects.
     *
     * Collection of prizes associated with the User
     *
     */
    protected $prizes = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Achievement",
     *     mappedBy="user",
     *     cascade={
     *          "persist",
     *          "remove"
     *      },
     *     orphanRemoval=TRUE
     * )
     *
     * @var Achievement[] An ArrayCollection of Achievement objects.
     *
     * Collection of Achievement associated with the User
     *
     */
    protected $achievements = null;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Organization",
     *     inversedBy="users"
     * )
     *
     * The realm that the user is associated with
     *
     */
    protected $organization = null;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(max=4096, groups={"registration"})
     */
    protected $plainPassword;

    /**
     * @var uuid
     * @ORM\Column(
     *     type="guid",
     *     unique=true
     * )
     *
     * Generated UUID to uniquely link to this user
     *
     * @Assert\NotBlank()
     *
     */
    protected $uuid;

    /**
     * @var Theme
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\System\Theme\Theme",
     *     inversedBy="users"
     * )
     *
     * The Theme the user has selected for use in their profile
     *
     */
    protected $theme = null;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\User\UserUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
     *
     *
     */
    protected $state;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organization\Config\Image")
     *
     * User Profile Picture
     *
     */
    protected $image = null;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Config\Type",
     *     inversedBy="users"
     * )
     *
     * The role that a user has in the realm
     *
     */
    protected $type = null;

    /**
     * @var int
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * The total points that a user has earned in the history of their account
     *
     */
    protected $total_points;

    /**
     * @var int
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * The points that a user is in progress towards earning their next trophy
     *
     */
    protected $trophy_points;

    /**
     * @var int
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * The points that a user has available to spend on prizes
     *
     */
    protected $prize_points;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->taskTemplates = new ArrayCollection();
        $this->prizes = new ArrayCollection();
        $this->achievements = new ArrayCollection();

    }

    /**
     * @param Achievement $achievement
     */
    public function addAchievement(Achievement $achievement)
    {
        $this->achievements[] = $achievement;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * @param Achievement $achievement
     * @return $this
     */
    public function removeAchievement(Achievement $achievement)
    {
        if ($this->achievements->contains($achievement)) {
            $this->achievements->removeElement($achievement);
            $achievement->setUser(null);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



    /**
     * @param Task $task
     */
    public function addTaskTemplate(Task $task)
    {
        $this->taskTemplates[] = $task;
    }

    /**
     * @return Task[]|ArrayCollection
     */
    public function getTaskTemplates()
    {
        return $this->taskTemplates;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setPassword($password)
    {
        $this->password = $password;
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

    /**
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param Theme $theme
     */
    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;
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
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getTotalPoints()
    {
        return $this->total_points;
    }

    /**
     * @param int $total_points
     */
    public function setTotalPoints($total_points)
    {
        $this->total_points = $total_points;
    }

    /**
     * @return int
     */
    public function getTrophyPoints()
    {
        return $this->trophy_points;
    }

    /**
     * @param int $trophy_points
     */
    public function setTrophyPoints($trophy_points)
    {
        $this->trophy_points = $trophy_points;
    }

    /**
     * @return int
     */
    public function getPrizePoints()
    {
        return $this->prize_points;
    }

    /**
     * @param int $prize_points
     */
    public function setPrizePoints($prize_points)
    {
        $this->prize_points = $prize_points;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * The bcrypt algorithm doesn't require a separate salt.
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getRoles()
    {
        return "ROLE_ADMIN";
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,

            ) = unserialize($serialized);
    }
}