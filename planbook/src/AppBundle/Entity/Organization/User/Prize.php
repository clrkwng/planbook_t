<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:28 PM
 */

namespace AppBundle\Entity\Organization\User;
use AppBundle\Entity\Organization\Config\Image;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @Assert\NotBlank
     * @Assert\Length(min = 2)
     */
    protected $name;

    /**
     * @var string
     * @Column(
     *     type="string",
     *     nullable=true
     * )
     */
    protected $description;

    /**
     * @var int
     * @Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     *
     * @label('The amount that it costs a user to purchase the prize')
     *
     */
    protected $price;

    /**
     * @var User
     * @ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\User\User",
     *     inversedBy="prizes"
     * )
     *
     * @label('The User that will have this prize appear in their marketplace')
     */
    protected $user;

    /**
     * @var Image
     * @ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Config\Image",
     *     inversedBy="prizes"
     * )
     * @label('The image that is displayed when a user views the prize')
     *
     */
    protected $image;

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\Organization\User\PrizeUtil",
     *          "getStates"
     *      }
     * )
     * @Column(type="string")
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