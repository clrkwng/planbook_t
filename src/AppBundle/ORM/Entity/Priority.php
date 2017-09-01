<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:54 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="priority")
 *
 * Per tenant definitions of
 *
 **/
class Priority
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
     *  Allows for the organization to define their own custom priorities with associated values
     *
     */
    protected $organization_id;

    /**
     * @var int
     * @Column(type="integer")
     *
     * How many points are given to the user upon completion of the task
     *
     */
    protected $completion_points;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Priority is active and available for use
     * "DISABLED"           = Admin has opted to turn off this Priority; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this Priority entirely
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