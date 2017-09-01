<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:57 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="theme")
 *
 *  Container of related colors
 *
 **/
class Theme
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
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Theme is active and can be chosen for use by Users
     * "DISABLED"           = Admin has opted to turn off this Theme for their organization; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this theme entirely
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