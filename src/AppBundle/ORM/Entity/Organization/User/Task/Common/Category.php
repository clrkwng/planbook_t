<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:50 PM
 */

namespace AppBundle\ORM\Entity\Organization\User\Task\Common;
use AppBundle\ORM\Entity\Organization\Config\Image;
use AppBundle\ORM\Entity\Organization\Organization;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Entity(repositoryClass="CategoryRepository") @Table(name="category")
 *
 * @label('Container for similar tasks; defined on a per tenant basis')
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
     * @var Image
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Config\Image",
     *     inversedBy="categories"
     * )
     *
     * @label('Icon rendered when the category is displayed')
     *
     */
    protected $image;

    /**
     * @var Organization
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Organization",
     *     inversedBy="categories"
     * )
     *
     * @label('Realm that this category exists in')
     *
     */
    protected $organization = null;

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
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImageId(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization= $organization;
    }





}