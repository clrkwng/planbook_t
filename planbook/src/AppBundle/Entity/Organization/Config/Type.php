<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:46 PM
 */

namespace AppBundle\Entity\Organization\Config;

use AppBundle\Entity\Organization\User\User;
use AppBundle\Repository\Organization\Config\TypeRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\Config\TypeRepository")
 *
 * Role that a user has in the Realm
 *
 **/
class Type
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
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     mappedBy="type"
     * )
     * @var User[] An ArrayCollection of User objects.
     *
     */
    protected $users = null;

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
     * Type constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();

    }

    /**
     * @return ArrayCollection|null
     *
     * All users that are of this type
     *
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * Set a user to this type
     *
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\Config\TypeUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
     *
     */
    protected $state;

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
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
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


}