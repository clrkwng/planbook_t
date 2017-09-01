<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/26/2017
 * Time: 11:18 AM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="theme_color")
 *
 * @label('Association of a theme to a color')
 *
 **/
class ThemeColor
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var Theme
     * @ManyToOne(targetEntity="Theme", inversedBy="colors")
     *
     * @label('The associated theme')
     *
     */
    protected $theme;

    /**
     * @var Color
     * @ManyToOne(targetEntity="Color", inversedBy="themes")
     *
     * @label('The associated color')
     *
     */
    protected $color;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param Theme $theme
     */
    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param Color $color
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
    }


}