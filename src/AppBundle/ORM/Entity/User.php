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



}