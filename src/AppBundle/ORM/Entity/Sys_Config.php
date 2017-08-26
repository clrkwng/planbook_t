<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:13 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="sys_config")
 **/
class Sys_Config
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
    protected $variable;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $value;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $set_time;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $set_by;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



}