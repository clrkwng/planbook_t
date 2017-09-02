<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:47 PM
 */

namespace AppBundle\ORM\Entity;
use AppBundle\ORM\Organization;
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
     * @ManyToOne(targetEntity="AppBundle\ORM\Organization", inversedBy="trophies")
     *
     * @label('Allows for the trophies to be defined on a per tenant basis')
     */
    protected $organization = null;

    /**
     * @var Image
     * @label('Icon displayed for the trophy')
     *
     * @ManyToOne(targetEntity="AppBundle\ORM\Entity\Image", inversedBy="trophies")
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
     * @OneToOne(targetEntity="AppBundle\ORM\Entity\Trophy", inversedBy="prev_trophy")
     *
     */
    protected $next_trophy = null;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * @label('
             * "ACTIVE"             = Trophy is active and can be awarded by Users
             * "DISABLED"           = Tenant has opted to turn off this trophy for their organization; Tenant can toggle back on
             * "DELETED"            = Tenant has chosen to delete this trophy
     *     ')
     *
     */
    protected $state;

    /**
     * Trophy constructor.
     */
    public function __construct()
    {

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