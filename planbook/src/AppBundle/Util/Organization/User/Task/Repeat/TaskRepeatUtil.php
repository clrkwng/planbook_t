<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:36 PM
 */

namespace AppBundle\ORM\Util\Organization\User\Task\Repeat;


class TaskRepeatUtil
{

    /**
    *  "ACTIVE"             = TaskRepeat is active and actively created new single occurrences
    *  "DISABLED"           = User has opted to temporarily turn off this TaskRepeat; User can toggle back on
    *  "DELETED"            = User has chosen to delete this TaskRepeat entirely
    *
    * @return array
    *
    */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }
}