<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:41 PM
 */

namespace AppBundle\Entity\Organization\User\Task\Repeat;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="frequency_meta")
 * @ORM\Entity(repositoryClass="FrequencyMetaRepository")
 *
 * Interval definition for a recurring task
 *
 **/
class FrequencyMeta
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Frequency
     *
     * Associated base frequency
     *
     * @ORM\ManyToOne(targetEntity="Frequency", inversedBy="metaData")
     *
     */
    protected $frequency = null;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     *
     *  Interval key:
     *      Values will either be 'repeat_start' or 'repeat_interval_#", where # is the id of the row it is defining the
     *      range for
     *
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     *
     */
    protected $meta_key;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     *
     *  Interval value:
     *       If meta_key ==  "repeat_start"      , then this is a Unix timestamp defining when the first occurrence of the
     *      series will be
     *
     *      If meta_key ==  "repeat_interval_#" , then this is the number of seconds before this interval is over
     *          For every 7 days, this is "604800"
     *          For every 5 days, this is "432000"
     *
     *
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     *
     */
    protected $meta_value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Frequency
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param Frequency $frequency
     */
    public function setFrequencyId(Frequency $frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @return string
     */
    public function getMetaKey()
    {
        return $this->meta_key;
    }

    /**
     * @param string $meta_key
     */
    public function setMetaKey($meta_key)
    {
        $this->meta_key = $meta_key;
    }

    /**
     * @return string
     */
    public function getMetaValue()
    {
        return $this->meta_value;
    }

    /**
     * @param string $meta_value
     */
    public function setMetaValue($meta_value)
    {
        $this->meta_value = $meta_value;
    }



}