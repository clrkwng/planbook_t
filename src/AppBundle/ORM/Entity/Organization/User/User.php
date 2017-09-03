<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:05 PM
 */

namespace AppBundle\ORM\Entity\Organization\User;
use AppBundle\ORM\Entity\Organization\Config\Image;
use AppBundle\ORM\Entity\Organization\Config\Type;
use AppBundle\ORM\Entity\Organization\Organization;
use AppBundle\ORM\Entity\Organization\User\Task\Task;
use AppBundle\ORM\Entity\System\Theme\Theme;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity(repositoryClass="UserRepository") @Table(name="user")
 *
 * @label('Account information for users on a per tenant basis')
 *
 **/
class User
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Task\Task",
     *     mappedBy="user"
     * )
     * @var Task[] An ArrayCollection of Task objects.
     * @label('Base Tasks Associated with the User')
     */
    protected $taskTemplates = null;

    /**
     * @OneToMany(targetEntity="Prize", mappedBy="user")
     * @var Prize[] An ArrayCollection of Prize objects.
     * @label('Collection of prizes associated with the User')
     */
    protected $prizes = null;

    /**
     * @OneToMany(
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
     * @label('Collection of Achievement associated with the User')
     */
    protected $achievements = null;

    /**
     * @var Organization
     *
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Organization",
     *     inversedBy="users"
     * )
     *
     * @label('The realm that the user is associated with')
     *
     */
    protected $organization = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $username;

    /**
     * @var Email
     * @Column(type="string")
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $password;

    /**
     * @var uuid
     * @Column(
     *     type="guid",
     *     unique=true
     * )
     *
     * @label('Generated UUID to uniquely link to this user')
     *
     */
    protected $uuid;

    /**
     * @var Theme
     *
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\System\Theme\Theme",
     *     inversedBy="users"
     * )
     *
     * @label('The Theme the user has selected for use in their profile')
     *
     */
    protected $theme = null;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\ORM\Util\Organization\User\UserUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
     *
     *
     */
    protected $state;

    /**
     * @var Image
     *
     * @OneToOne(targetEntity="AppBundle\ORM\Entity\Organization\Config\Image")
     *
     * @label('User Profile Picture')
     *
     */
    protected $image = null;

    /**
     * @var Type
     *
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Config\Type",
     *     inversedBy="users"
     * )
     *
     * @label('The role that a user has in the realm')
     *
     */
    protected $type = null;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * @label('The total points that a user has earned in the history of their account')
     *
     */
    protected $total_points;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * @label('The points that a user is in progress towards earning their next trophy')
     *
     */
    protected $trophy_points;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * @label('The points that a user has available to spend on prizes')
     *
     */
    protected $prize_points;

    /**
     * User constructor.
     */
    public function __construct()
    {
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





}