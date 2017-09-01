<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:46 PM
 */

namespace AppBundle\ORM\Entity;


/**
 * @Entity @Table(name="type")
 *
 * @Label('Role that a user has in the Realm')
 *
 **/
class Type
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
     * @label('
     *      "ACTIVE"             = Type is active and can be used
     *      "DISABLED"           = Tenant has opted to turn off this role for their organization; Tenant can toggle back on
     *      "DELETED"            = Tenant has chosen to delete this role
     *     ')
     *
     */
    protected $state;

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