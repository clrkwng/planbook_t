<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:28 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="prize")
 **/
class Prize
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
     * @Column(type="string")
     */
    protected $description;

    /**
     * @var int
     * @Column(type="integer")
     *
     *  The amount that it costs a user to purchase the prize
     *
     */
    protected $price;

    /**
     * @var int
     * @Column(type="integer")
     * @Id
     *
     * The User that will have this prize appear in their marketplace
     */
    protected $user_id;

    /**
     * @var int
     * @Column(type="integer")
     * @Id
     *
     * The image that is displayed when a user views the prize
     *
     */
    protected $image_id;

    /**
     * @var string
     * @Enum({"NOT_VIEWED", "IN_PROGRESS", "REDEEMED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "NOT_VIEWED"     = User is prompted with a notification
     * "IN_PROGRESS"    = User can view in marketplace
     * "DISABLED"       = Hidden from user's display; Admin can see the prize, edit, and toggle the prize's visibility
     * "DELETED"        = Hidden from both the user and the admin's display
     *
     */
    protected $state;

}