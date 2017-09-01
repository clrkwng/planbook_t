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
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Trophy is active and can be awarded by Users
     * "DISABLED"           = Tenant has opted to turn off this trophy for their organization; Tenant can toggle back on
     * "DELETED"            = Tenant has chosen to delete this trophy
     *
     */
    protected $state;

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
    public function getAmountNeededNext()
    {
        return $this->amount_needed_next;
    }

    /**
     * @param int $amount_needed_next
     */
    public function setAmountNeededNext($amount_needed_next)
    {
        $this->amount_needed_next = $amount_needed_next;
    }

    /**
     * @return int
     */
    public function getNextTrophy()
    {
        return $this->next_trophy;
    }

    /**
     * @param int $next_trophy
     */
    public function setNextTrophy($next_trophy)
    {
        $this->next_trophy = $next_trophy;
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




}