<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function getUsersAction($slug)
    {} // "get_organization_users"   [GET] /organization/{slug}/user

    public function getUserAction($slug, $id)
    {} // "get_organization_user"    [GET] /organization/{slug}/user/{id}

    public function deleteUserAction($slug, $id)
    {} // "delete_organization_user" [DELETE] /organization/{slug}/user/{id}

    public function newUserAction($slug)
    {} // "new_organization_user"   [GET] /organization/{slug}/user/new

    public function editUserAction($slug, $id)
    {} // "edit_organization_user"   [GET] /organization/{slug}/user/{id}/edit


}