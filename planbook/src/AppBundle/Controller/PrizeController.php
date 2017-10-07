<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PrizeController extends Controller
{

    public function getPrizesAction($slug, $userId)
    {} // "get_organization_user_prizes"   [GET] /organization/{slug}/user/{userId}/prize

    public function getPrizeAction($slug, $userId, $id)
    {} // "get_organization_user_prize"    [GET] /organization/{slug}/user/{userId}/prize/{id}

    public function deletePrizeAction($slug, $userId, $id)
    {} // "delete_organization_user_prize" [DELETE] /organization/{slug}/user/{userId}/prize/{id}

    public function newPrizeAction($slug, $userId)
    {} // "new_organization_user_prize"   [GET] /organization/{slug}/user/{userId}/prize/new

    public function editPrizeAction($slug, $userId, $id)
    {} // "edit_organization_user_prize"   [GET] /organization/{slug}/user/{userId}/prize/{id}/edit

}