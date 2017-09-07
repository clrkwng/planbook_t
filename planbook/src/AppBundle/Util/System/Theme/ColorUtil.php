<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:21 PM
 */

namespace AppBundle\Util\System\Theme;

class ColorUtil
{
    /**
     * "ACTIVE"             = Color is active and available for use
     * "DISABLED"           = Admin has opted to turn off access to this Color; Admin can toggle back on
     * "DELETED"            = Admin has chosen to delete this Color entirely
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}