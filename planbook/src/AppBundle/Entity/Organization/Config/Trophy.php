<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:47 PM
 */

namespace AppBundle\Entity\Organization\Config;

use AppBundle\Entity\Organization\Organization;
use AppBundle\Entity\Organization\User\Achievement;
use AppBundle\Repository\Organization\Config\TrophyRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * @ORM\Table(name="trophy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\Config\TrophyRepository")
 *
 * Per tenant definitions of trophies that are earned by a user completing tasks
 *
 **/
class Trophy
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
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Organization",
     *     inversedBy="trophies"
     * )
     *
     * Allows for the trophies to be defined on a per tenant basis
     */
    protected $organization = null;

    /**
     * @var Image
     * Icon displayed for the trophy
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Config\Image",
     *     inversedBy="trophies"
     * )
     *
     */
    protected $image = null;

    /**
     * @var int
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     *
     * Quantity of this trophy needed to increment to the next trophy
     *
     */
    protected $amount_needed_next;

    /**
     * @var Trophy
     *
     * The trophy to increment to after $amount_needed_next == UserTrophy.$amount
     *
     * @ORM\OneToOne(
     *     targetEntity="AppBundle\Entity\Organization\Config\Trophy"
     * )
     *
     */
    protected $next_trophy = null;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\Config\TrophyUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
     *
     */
    protected $state;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Organization\User\Achievement",
     *     mappedBy="trophy",
     *     cascade={
     *          "persist",
     *          "remove"
     *      },
     *     orphanRemoval=TRUE
     * )
     *
     * @var Achievement[] An ArrayCollection of Achievement objects.
     *
     * Collection of Achievement associated with the User
     *
     */
    protected $achievements = null;

    /**
     * @ORM\Column(length=255, unique=true)
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     *
     * Allows for the trophy to be accessed via a url
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
     * Trophy constructor.
     */
    public function __construct()
    {
        $this->achievements = new ArrayCollection();
    }

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
        $this->organization = $organization;
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
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return Achievement[]|ArrayCollection
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * @param Achievement $achievement
     * @return $this
     */
    public function addAchievement(Achievement $achievement)
    {
        if (!$this->achievements->contains($achievement)) {
            $this->achievements[] = $achievement;
        }
        return $this;
    }

    /**
     * @param Achievement $achievement
     * @return $this
     */
    public function removeAchievement(Achievement $achievement)
    {
        if ($this->achievements->contains($achievement)) {
            $this->achievements->removeElement($achievement);
            $achievement->setTrophy(null);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountNeededNext()
    {
        return $this->amount_needed_next;
    }

    /**
     * @param int $amount_needed_next
     */
    public function setAmountNeededNext($amount_needed_next)
    {
        $this->amount_needed_next = $amount_needed_next;
    }

    /**
     * @return Trophy
     */
    public function getNextTrophy()
    {
        return $this->next_trophy;
    }

    /**
     * @param Trophy $next_trophy
     */
    public function setNextTrophy(Trophy $next_trophy)
    {
        $this->next_trophy = $next_trophy;
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


}