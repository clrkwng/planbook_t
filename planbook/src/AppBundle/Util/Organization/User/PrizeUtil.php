<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:28 PM
 */

namespace AppBundle\ORM\Util\Organization\User;


class PrizeUtil
{

    /**
     *
     * "NOT_VIEWED"     = User is prompted with a notification
     * "IN_PROGRESS"    = User can view in marketplace
     * "DISABLED"       = Hidden from user's display; Admin can see the prize, edit, and toggle the prize's visibility
     * "DELETED"        = Hidden from both the user and the admin's display
     *
     * @return array
     */
    public static function getStates()
    {
        return array('NOT_VIEWED', 'IN_PROGRESS', 'DISABLED', 'DELETED');
    }
}