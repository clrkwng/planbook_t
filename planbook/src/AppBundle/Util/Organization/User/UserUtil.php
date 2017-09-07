<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/2/2017
 * Time: 9:26 PM
 */

namespace AppBundle\Util\Organization\User;

class UserUtil
{
    /**
     *  "NOT_ACTIVATED"      = Account has been created, but user has not triggered a verification email
     *  "VERIFICATION_SENT"  = User has a verification email awaiting their confirmation
     *  "VERIFIED"           = User can login under normal conditions
     *  "DISABLED"           = User's account has been disabled by an admin; Login is blocked; Admin can re-enable
     *  "DELETED"            = Admin has deleted this user;
     *
     * @return array
     */
    public static function getStates()
    {
        return array('NOT_ACTIVATED', 'VERIFICATION_SENT', 'VERIFIED', 'DISABLED', 'DELETED');
    }

}