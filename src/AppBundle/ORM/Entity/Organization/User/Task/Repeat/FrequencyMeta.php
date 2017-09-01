<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 8:41 PM
 */

namespace AppBundle\ORM\Entity;


/**
 * @Entity @Table(name="frequency_meta")
 *
 * @label('Interval definition for a recurring task')
 *
 **/
class FrequencyMeta
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;


    /**
     * @var Frequency
     *
     * @label('Associated base frequency')
     *
     * @ManytoOne(targetEntity="Frequency", inversedBy="metaData")
     *
     */
    protected $frequency = null;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('
     *      Interval key:
     *          Values will either be 'repeat_start' or 'repeat_interval_#", where # is the id of the row it is defining the
     *          range for
     *     ')
     *
     */
    protected $meta_key;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('
     *      Interval value:
     *          If meta_key ==  "repeat_start"      , then this is a Unix timestamp defining when the first occurrence of the
     *          series will be
     *
     *          If meta_key ==  "repeat_interval_#" , then this is the number of seconds before this interval is over
     *              For every 7 days, this is "604800"
     *              For every 5 days, this is "432000"
     *
     *     ')
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