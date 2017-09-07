<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:31 PM
 */

namespace AppBundle\Util\Organization\User\Task;

class TaskUtil
{

    /**
     *
     * "ACTIVE"             = Task is active and available for Users to create instances of
     * "DISABLED"           = User has opted to temporarily turn off this Task; User can toggle back on
     * "DELETED"            = User has chosen to delete this Task entirely
     *
     * @return array
     */
    public static function getStates()
    {
        return array('ACTIVE', 'DISABLED', 'DELETED');
    }

}