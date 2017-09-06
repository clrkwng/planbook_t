<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:41 PM
 */

namespace AppBundle\ORM\Util\Organization\User\Task\Common;


class PriorityUtil
{
    /**
     *  "ACTIVE"             = Priority is active and available for use
     *  "DISABLED"           = Admin has opted to turn off this Priority; Admin can toggle back on
     *  "DELETED"            = Admin has chosen to delete this Priority entirely
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}