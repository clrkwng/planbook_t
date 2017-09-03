<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 7:53 PM
 */

namespace AppBundle\ORM\Entity\Organization\User;
use AppBundle\ORM\Entity\Organization\Config\Trophy;


/**
 * @Entity @Table(name="achievements")
 *
 * @label('Mapping of Users to Trophies with Additional Data')
 *
 **/
class Achievement
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\User",
     *     inversedBy="achievements"
     * )
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $user;

    /**
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Config\Trophy",
     *     inversedBy="achievements"
     * )
     * @JoinColumn(name="trophy_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $trophy;

    /**
     * @Column(type="integer", name="quantity")
     */
    protected $quantity;

    /**
     * @return integer
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
    public function setUser(User $user = null)
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
    public function setTrophy(Trophy $trophy = null)
    {
        $this->trophy = $trophy;
    }

    /**
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }





}