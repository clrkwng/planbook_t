<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:35 PM
 */

namespace AppBundle\ORM\Util\Organization\User\Task\Repeat;


class FrequencyUtil
{

    /**
     *
     *  "ACTIVE"             = Frequency is active and available for use
     *  "DISABLED"           = Access to this Frequency has been turned off
     *  "DELETED"            = This Frequency has been removed from use
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}