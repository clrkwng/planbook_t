<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:05 PM
 */

namespace AppBundle\ORM\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="user")
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
     * @OneToMany(targetEntity="Task", mappedBy="user")
     * @var Task[] An ArrayCollection of Task objects.
     * @label('Base Tasks Associated with the User')
     */
    protected $taskTemplates = null;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * @label('The realm that the user is associated with')
     *
     */
    protected $organization_id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $password;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('Generated UUID to uniquely link to this user')
     *
     */
    protected $uuid;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     *
     * @label('The Theme the user has selected for use in their profile')
     *
     */
    protected $theme_id;

    /**
     * @var string
     * @Enum({"NOT_ACTIVATED", "VERIFICATION_SENT", "VERIFIED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * @label('
     *      "NOT_ACTIVATED"      = Account has been created, but user has not triggered a verification email
     *      "VERIFICATION_SENT"  = User has a verification email awaiting their confirmation
     *      "VERIFIED"           = User can login under normal conditions
     *      "DISABLED"           = User's account has been disabled by an admin; Login is blocked; Admin can re-enable
     *      "DELETED"            = Admin has deleted this user;
     *     ')
     *
     */
    protected $state;

    /**
     * @var Image
     *
     * @OneToOne(targetEntity="Image")
     *
     * @label('User Profile Picture')
     *
     */
    protected $image;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * @label('The role that a user has in the realm')
     *
     */
    protected $type_id;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @label('The total points that a user has earned in the history of their account')
     *
     */
    protected $total_points;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @label('The points that a user is in progress towards earning their next trophy')
     *
     */
    protected $trophy_points;

    /**
     * @var int
     * @Column(type="integer")
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOrganizationId()
    {
        return $this->organization_id;
    }

    /**
     * @param int $organization_id
     */
    public function setOrganizationId($organization_id)
    {
        $this->organization_id = $organization_id;
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
     * @return int
     */
    public function getThemeId()
    {
        return $this->theme_id;
    }

    /**
     * @param int $theme_id
     */
    public function setThemeId($theme_id)
    {
        $this->theme_id = $theme_id;
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
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param int $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
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