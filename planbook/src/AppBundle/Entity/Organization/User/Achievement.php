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





}