<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:39 PM
 */

namespace AppBundle\ORM\Entity;


/**
 * @Entity @Table(name="frequency")
 *
 * Base definition for a recurring task
 *
 **/
class Frequency
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
     *
     * Name associated with this frequency set
     *  (ex: "Every Tuesday", "Every Day", "Every n days", etc)
     *
     */
    protected $name;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Frequency is active and available for use
     * "DISABLED"           = Access to this Frequency has been turned off
     * "DELETED"            = This Frequency has been removed from use
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

}