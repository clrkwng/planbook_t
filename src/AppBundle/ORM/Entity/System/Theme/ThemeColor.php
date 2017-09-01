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
 * Association of a theme to a color
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
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Theme` table
     *
     * The associated theme
     *
     */
    protected $theme_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Foreign key to `Color` table
     *
     * The associated color
     *
     */
    protected $color_id;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getThemeId()
    {
        return $this->theme_id;
    }

    /**
     * @param int $theme_id
     */
    public function setThemeId($theme_id)
    {
        $this->theme_id = $theme_id;
    }

    /**
     * @return int
     */
    public function getColorId()
    {
        return $this->color_id;
    }

    /**
     * @param int $color_id
     */
    public function setColorId($color_id)
    {
        $this->color_id = $color_id;
    }


}