<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:47 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="trophy")
 *
 * Per tenant definitions of trophies that are earned by a user completing tasks
 *
 **/
class Trophy
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
     * @var int
     * @Id
     * @Column(type="integer")
     *
     *  Allows for the trophies to be defined on a per tenant basis
     */
    protected $organization_id;

    /**
     * @var int
     * @Column(type="integer")
     * @Id
     *
     * Icon displayed for the trophy
     *
     */
    protected $image_id;

    /**
     * @var int
     * @Column(type="integer")
     *
     *  Quantity of this trophy needed to increment to the next trophy
     */
    protected $amount_needed_next;

    /**
     * @var int
     * @Column(type="integer")
     *
     *  The trophy to increment to after $amount_needed_next == UserTrophy.$amount
     *
     */
    protected $next_trophy;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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