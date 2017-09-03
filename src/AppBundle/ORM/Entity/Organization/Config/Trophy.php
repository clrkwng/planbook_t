<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:47 PM
 */

namespace AppBundle\ORM\Entity\Organization\Config;
use AppBundle\ORM\Entity\Organization\Organization;
use AppBundle\ORM\Entity\Organization\User\Achievement;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="TrophyRepository") @Table(name="trophy")
 *
 * @Label('Per tenant definitions of trophies that are earned by a user completing tasks')
 *
 **/
class Trophy
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
     * @var Organization
     *
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Organization",
     *     inversedBy="trophies"
     * )
     *
     * @label('Allows for the trophies to be defined on a per tenant basis')
     */
    protected $organization = null;

    /**
     * @var Image
     * @label('Icon displayed for the trophy')
     *
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Config\Image",
     *     inversedBy="trophies"
     * )
     *
     */
    protected $image = null;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @label('Quantity of this trophy needed to increment to the next trophy')
     */
    protected $amount_needed_next;

    /**
     * @var Trophy
     *
     * @label('The trophy to increment to after $amount_needed_next == UserTrophy.$amount')
     *
     * @OneToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Config\Trophy"
     * )
     *
     */
    protected $next_trophy = null;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\ORM\Util\Organization\Config\TrophyUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
     *
     */
    protected $state;

    /**
     * @OneToMany(
     *     targetEntity="AppBundle\ORM\Entity\Organization\User\Achievement",
     *     mappedBy="trophy",
     *     cascade={
     *          "persist",
     *          "remove"
     *      },
     *     orphanRemoval=TRUE
     * )
     *
     * @var Achievement[] An ArrayCollection of Achievement objects.
     * @label('Collection of Achievement associated with the User')
     */
    protected $achievements = null;


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
     */
    public function addAchievement(Achievement $achievement)
    {
        $this->achievements[] = $achievement;
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




}