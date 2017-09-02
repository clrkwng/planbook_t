<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:28 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity(repositoryClass="PrizeRepository") @Table(name="prize")
 **/
class Prize
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
     * @var string
     * @Column(type="string")
     */
    protected $description;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @label('The amount that it costs a user to purchase the prize')
     *
     */
    protected $price;

    /**
     * @var User
     * @ManyToOne(targetEntity="AppBundle\ORM\Entity\User", inversedBy="prizes")
     *
     * @label('The User that will have this prize appear in their marketplace')
     */
    protected $user;

    /**
     * @var Image
     * @ManyToOne(targetEntity="AppBundle\ORM\Entity\Image", inversedBy="prizes")
     * @label('The image that is displayed when a user views the prize')
     *
     */
    protected $image;

    /**
     * @var string
     * @Enum({"NOT_VIEWED", "IN_PROGRESS", "REDEEMED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "NOT_VIEWED"     = User is prompted with a notification
     * "IN_PROGRESS"    = User can view in marketplace
     * "DISABLED"       = Hidden from user's display; Admin can see the prize, edit, and toggle the prize's visibility
     * "DELETED"        = Hidden from both the user and the admin's display
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
    public function setUser(User $user)
    {
        $this->user = $user;
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