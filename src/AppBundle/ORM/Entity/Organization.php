<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:27 PM
 */

namespace AppBundle\ORM;

/**
 * @Entity @Table(name="organization")
 *
 * Realm (collection) of users
 *
 **/
class Organization
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
     *
     * Generated UUID that can be used to link uniquely to a particular tenant
     *
     */
    protected $uuid;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



}