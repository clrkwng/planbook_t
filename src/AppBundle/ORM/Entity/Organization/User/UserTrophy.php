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
 *
 * Mapping of a User to their trophies and the associated quantities
 *
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
     *
     * Foreign key to `User` table
     *
     * The associated User
     *
     */
    protected $user_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Trophy` table
     *
     * The associated Trophy
     *
     */
    protected $trophy_id;

    /**
     * @var int
     * @Column(type="integer")
     *
     * The quantity of this trophy that this user has
     *
     */
    protected $amount;


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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getTrophyId()
    {
        return $this->trophy_id;
    }

    /**
     * @param int $trophy_id
     */
    public function setTrophyId($trophy_id)
    {
        $this->trophy_id = $trophy_id;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


}