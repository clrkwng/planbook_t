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
     * @return int
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * @param int $image_id
     */
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;
    }

    /**
     * @return int
     */
    public function getOrganizationId()
    {
        return $this->organization_id;
    }

    /**
     * @param int $organization_id
     */
    public function setOrganizationId($organization_id)
    {
        $this->organization_id = $organization_id;
    }





}