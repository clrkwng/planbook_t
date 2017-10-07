<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThemeController extends Controller
{
    public function getThemesAction($slug, $userId)
    {} // "get_organization_user_themes"   [GET] /organization/{slug}/user/{userId}/theme

    public function getThemeAction($slug, $userId, $id)
    {} // "get_organization_user_theme"    [GET] /organization/{slug}/user/{userId}/theme/{id}

    public function deleteThemeAction($slug, $userId, $id)
    {} // "delete_organization_user_theme" [DELETE] /organization/{slug}/user/{userId}/theme/{id}

    public function newThemeAction($slug, $userId)
    {} // "new_organization_user_theme"   [GET] /organization/{slug}/user/{userId}/theme/new

    public function editThemeAction($slug, $userId, $id)
    {} // "edit_organization_user_theme"   [GET] /organization/{slug}/user/{userId}/theme/{id}/edit

}