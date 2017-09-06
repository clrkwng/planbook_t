<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:47 PM
 */

namespace AppBundle\ORM\Util\Organization\Config;


class TypeUtil
{

    /**
     *  "ACTIVE"             = Type is active and can be used
     *  "DISABLED"           = Tenant has opted to turn off this role for their organization; Tenant can toggle back on
     *  "DELETED"            = Tenant has chosen to delete this role
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}