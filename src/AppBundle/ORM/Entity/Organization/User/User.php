<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:05 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="user")
 *
 * Account information for users on a per tenant basis
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
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Organization` table
     *
     * The realm that the user is in
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
     * Generated UUID to uniquely link to this user
     *
     */
    protected $uuid;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Theme` table
     *
     * The Theme the user has selected for use in their profile
     *
     */
    protected $theme_id;

    /**
     * @var string
     * @Enum({"NOT_ACTIVATED", "VERIFICATION_SENT", "VERIFIED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "NOT_ACTIVATED"      = Account has been created, but user has not triggered a verification email
     * "VERIFICATION_SENT"  = User has a verification email awaiting their confirmation
     * "VERIFIED"           = User can login under normal conditions
     * "DISABLED"           = User's account has been disabled by an admin; Login is blocked; Admin can re-enable
     * "DELETED"            = Admin has deleted this user;
     *
     */
    protected $state;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Image` table
     *
     *  User Profile Picture
     *
     */
    protected $image_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Type` table
     *
     * The role that a user has in the realm
     *
     */
    protected $type_id;

    /**
     * @var int
     * @Column(type="integer")
     *
     * The total points that a user has earned in the history of their account
     *
     */
    protected $total_points;

    /**
     * @var int
     * @Column(type="integer")
     *
     * The points that a user is in progress towards earning their next trophy
     *
     */
    protected $trophy_points;

    /**
     * @var int
     * @Column(type="integer")
     *
     * The points that a user has available to spend on prizes
     *
     */
    protected $prize_points;


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
     * @return int
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * @param int $image_id
     */
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;
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