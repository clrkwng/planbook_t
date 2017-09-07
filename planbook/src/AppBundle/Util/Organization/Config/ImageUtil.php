<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:44 PM
 */

namespace AppBundle\Util\Organization\Config;

class ImageUtil
{
    /**
     *  "ACTIVE"             = Image is active and available for use
     *  "DISABLED"           = Admin has opted to turn off access to this Image; Admin can toggle back on
     *  "DELETED"            = Admin has chosen to delete this Image entirely
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }

}