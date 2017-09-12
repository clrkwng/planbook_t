<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 8:57 PM
 */

namespace AppBundle\Entity\System\Theme;

use AppBundle\Repository\System\Theme\ColorRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Table(name="color")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\System\Theme\ColorRepository")
 *
 * Basic definitions for colors
 *
 **/
class Color
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
     * @Assert\Length(min = 3)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 4)
     */
    protected $hex_value;

    /**
     * Color constructor.
     */
    public function __construct()
    {

    }

    /**
     * @var string
     * @Assert\Choice(
     *     callback = {
     *          "AppBundle\Util\System\Theme\ColorUtil",
     *          "getStates"
     *      }
     * )
     * @ORM\Column(type="string")
     */
    protected $state;

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
    public function getHexValue()
    {
        return $this->hex_value;
    }

    /**
     * @param string $hex_value
     */
    public function setHexValue($hex_value)
    {
        $this->hex_value = $hex_value;
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