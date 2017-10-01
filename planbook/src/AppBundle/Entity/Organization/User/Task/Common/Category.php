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
use Gedmo\Mapping\Annotation as Gedmo;



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
     * @ORM\Column(length=255, unique=true)
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     *
     * Allows for the category to be accessed via a url
     *
     */
    protected $slug;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

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

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function __toString(){
        if($this->getName() == null){
            return "Category";
        }
        return $this->getName();
    }


}