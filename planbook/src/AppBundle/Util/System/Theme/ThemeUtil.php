<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:16 PM
 */

namespace AppBundle\Util\System\Theme;

class ThemeUtil
{
    /**
     * "ACTIVE"             = Theme is active and can be chosen for use by Users
     * "DISABLED"           = Admin has opted to turn off this Theme for their organization; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this theme entirely
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}