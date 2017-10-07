<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 7:53 PM
 */

namespace AppBundle\Entity\Organization\User;

use AppBundle\Entity\Organization\Config\Trophy;
use AppBundle\Repository\Organization\User\AchievementRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Table(name="achievements")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\User\AchievementRepository")
 *
 * Mapping of Users to Trophies with Additional Data
 *
 **/
class Achievement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     inversedBy="achievements"
     * )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $user;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Config\Trophy",
     *     inversedBy="achievements"
     * )
     * @ORM\JoinColumn(name="trophy_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $trophy;

    /**
     * @ORM\Column(type="integer", name="quantity")
     *
     * @Assert\GreaterThanOrEqual(0)
     */
    protected $quantity;

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
     * @ORM\Column(length=510, unique=true)
     *
     * @Gedmo\Slug(fields={"id"}, updatable=false)
     *
     * Allows for the image to be accessed via a url
     * (Note: Since this slug is a composite of user and trophy, it's length needs to be double)
     *
     */
    protected $slug;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return Trophy
     */
    public function getTrophy()
    {
        return $this->trophy;
    }

    /**
     * @param Trophy $trophy
     */
    public function setTrophy(Trophy $trophy = null)
    {
        $this->trophy = $trophy;
    }

    /**
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

    public function __toString(){
        return $this->getUser()->getUsername() .':' . $this->getTrophy()->getName() . ':' . $this->getQuantity();
    }


}