<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 10:05 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="user_trophy")
 **/
class UserTrophy
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
     */
    protected $user_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     */
    protected $trophy_id;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $amount;
}