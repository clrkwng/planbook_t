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
 * @label('Mapping of a User to their trophies and the associated quantities')
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
     * @var User
     *
     * @ManyToOne(targetEntity="User", mappedBy="trophies")
     *
     * @label('The associated User')
     *
     */
    protected $user = null;

    /**
     * @var Trophy
     *
     * @ManyToOne(targetEntity="Trophy", mappedBy="users")
     *
     * @label('The associated Trophy')
     *
     */
    protected $trophy = null;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUserId(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Trophy
     */
    public function getTrophy()
    {
        return $this->trophy;
    }

    /**
     * @param Trophy $trophy
     */
    public function setTrophy(Trophy $trophy)
    {
        $this->trophy = $trophy;
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