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
     * The Theme the user has selected for use in their profile
     *
     */
    protected $theme_id;

    /**
     * @var string
     * @Enum({"NOT_ACTIVATED", "VERIFICATION_SENT", "VERIFIED", "DISABLED", "DELETED"})
     * @Column(type="string")
     */
    protected $state;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     *  User Profile Picture
     *
     */
    protected $image_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     */
    protected $type_id;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $total_points;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $current_points;



}