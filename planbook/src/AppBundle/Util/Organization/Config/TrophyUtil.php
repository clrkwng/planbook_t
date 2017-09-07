<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:46 PM
 */

namespace AppBundle\Util\Organization\Config;

class TrophyUtil
{

    /**
     *  "ACTIVE"             = Trophy is active and can be awarded by Users
     *  "DISABLED"           = Tenant has opted to turn off this trophy for their organization; Tenant can toggle back on
     *  "DELETED"            = Tenant has chosen to delete this trophy
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}