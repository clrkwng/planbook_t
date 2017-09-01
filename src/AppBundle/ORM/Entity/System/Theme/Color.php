<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:57 PM
 */

namespace AppBundle\ORM\Entity;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @OneToMany(targetEntity="ThemeColor", mappedBy="color")
     * @var ThemeColor[] An ArrayCollection of ThemeColor objects.
     * @label('Collection of themes associated with the color')
     */
    protected $themes = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $hex_value;

    /**
     * Color constructor.
     */
    public function __construct()
    {
        $this->themes = new ArrayCollection();
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

    /**
     * @param ThemeColor $theme
     */
    public function addTheme(ThemeColor $theme){
        $this->themes[] = $theme;
    }

    /**
     * @return ThemeColor[]|ArrayCollection
     */
    public function getThemes()
    {
        return $this->themes;
    }

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
    public function getHexValue()
    {
        return $this->hex_value;
    }

    /**
     * @param string $hex_value
     */
    public function setHexValue($hex_value)
    {
        $this->hex_value = $hex_value;
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