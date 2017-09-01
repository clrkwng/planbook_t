<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:57 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="color")
 *
 * Basic definitions for colors
 *
 **/
class Color
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
    protected $hex_value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Color is active and available for use
     * "DISABLED"           = Admin has opted to turn off access to this Color; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this Color entirely
     *
     */
    protected $state;


}