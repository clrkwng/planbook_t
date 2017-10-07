<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AchievementController extends Controller
{

    public function getAchievementsAction($slug, $userId)
    {} // "get_organization_user_achievements"   [GET] /organization/{slug}/user/{userId}/achievement

    public function getAchievementAction($slug, $userId, $id)
    {} // "get_organization_user_achievement"    [GET] /organization/{slug}/user/{userId}/achievement/{id}

    public function deleteAchievementAction($slug, $userId, $id)
    {} // "delete_organization_user_achievement" [DELETE] /organization/{slug}/user/{userId}/achievement/{id}

    public function newAchievementAction($slug, $userId)
    {} // "new_organization_user_achievement"   [GET] /organization/{slug}/user/{userId}/achievement/new

    public function editAchievementAction($slug, $userId, $id)
    {} // "edit_organization_user_achievement"   [GET] /organization/{slug}/user/{userId}/achievement/{id}/edit

}