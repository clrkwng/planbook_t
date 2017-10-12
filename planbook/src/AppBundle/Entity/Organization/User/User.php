<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:05 PM
 */

namespace AppBundle\Entity\Organization\User;

use AppBundle\Entity\Organization\Config\Image;
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
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

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
 * @Serializer\XmlRoot("user")
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
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organization\Config\Image")
     *
     * User Profile Picture
     *
     */
    protected $image = null;

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
     * @ORM\Column(length=255, unique=true)
     *
     * @Gedmo\Slug(fields={"username"}, updatable=false)
     *
     * Allows for the user to be accessed via a url
     *
     */
    protected $slug;

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
     * @var array
     */
    protected $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->taskTemplates = new ArrayCollection();
        $this->prizes = new ArrayCollection();
        $this->achievements = new ArrayCollection();
        $this->roles = new ArrayCollection();

    }

    /**
     * @param string $role
     * @return $this
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param Achievement $achievement
     * @return $this
     */
    public function addAchievement(Achievement $achievement)
    {
        if (!$this->achievements->contains($achievement)) {
            $this->achievements[] = $achievement;
        }
        return $this;
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
     * @return $this
     */
    public function addTaskTemplate(Task $task)
    {
        if (!$this->taskTemplates->contains($task)) {
            $this->taskTemplates[] = $task;
        }
        return $this;
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
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->toArray();
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

    public function __toString(){
        $retStr = 'User';
        if(!is_null($this->getUsername()) && $this->getUsername() != ""){
            $retStr = $this->getUsername();
        }
        return (string) $retStr;
    }
}