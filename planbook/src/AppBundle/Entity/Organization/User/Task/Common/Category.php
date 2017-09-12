<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:50 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Common;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Repository\Organization\User\Task\Common\CategoryRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\Task\Common\CategoryRepository")
 *
 * Container for similar tasks; defined on a per tenant basis
 *
 **/
class Category
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 2)
     */
    protected $name;

    /**
     * @var Image
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Config\Image",
     *     inversedBy="categories"
     * )
     *
     * Icon rendered when the category is displayed
     *
     */
    protected $image;

    /**
     * @var Organization
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Organization",
     *     inversedBy="categories"
     * )
     *
     * Realm that this category exists in
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