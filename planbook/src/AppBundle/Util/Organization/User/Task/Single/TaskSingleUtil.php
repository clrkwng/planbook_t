<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:32 PM
 */

namespace AppBundle\ORM\Util\Organization\User\Task\Single;


class TaskSingleUtil
{

    /**
     *
     * "NOT_VIEWED"     = User is prompted with a notification
     * "IN_PROGRESS"    = User can view in their task dashboard; User can mark as complete
     * "COMPLETED"      = User can view in their task dashboard; User can not mark as complete; Points have been added
     * "DISABLED"       = Hidden from user's display; Admin can see the task, edit, and toggle the task's visibility
     * "DELETED"        = Hidden from both the user and the admin's display
     *
     *
     * @return array
     */
    public static function getStates()
    {
        return array('NOT_VIEWED', 'IN_PROGRESS', 'COMPLETED', 'DISABLED', 'DELETED');
    }
}