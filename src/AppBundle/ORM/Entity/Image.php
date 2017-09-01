<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:53 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="image")
 *
 * Per tenant container of uploaded images
 *
 **/
class Image
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
     * Allows for an organization to build up and manage their own repository of uploaded images
     *
     */
    protected $organization_id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $description;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $link;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Image is active and available for use
     * "DISABLED"           = Admin has opted to turn off access to this Image; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this Image entirely
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



}