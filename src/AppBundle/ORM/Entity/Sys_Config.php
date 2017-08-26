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
 *
 * Global configurations for the deployment environment
 *
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
     *
     * Timestamp for when this record was created
     *
     */
    protected $created_time;

    /**
     * @var string
     * @Column(type="string")
     *
     * Timestamp for when this record was last updated
     *
     */
    protected $updated_time;

    /**
     * @var string
     * @Column(type="string")
     *
     * User that last updated this record
     *
     */
    protected $updated_by;

    /**
     * @var string
     * @Column(type="string")
     *
     * User that initially created this record
     *
     */
    protected $created_by;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



}