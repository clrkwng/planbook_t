<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:50 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="category")
 *
 * Container for similar tasks; defined on a per tenant basis
 *
 **/
class Category
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
     *  Icon rendered when the category is displayed
     *
     */
    protected $image_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     *  Realm that this category exists in
     *
     */
    protected $organization_id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



}