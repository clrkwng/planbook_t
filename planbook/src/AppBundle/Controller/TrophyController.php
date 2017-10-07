<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrophyController extends Controller
{

    public function getTrophiesAction($slug)
    {} // "get_organization_trophies"   [GET] /organization/{slug}/trophy

    public function getTrophyAction($slug, $id)
    {} // "get_organization_trophy"    [GET] /organization/{slug}/trophy/{id}

    public function deleteTrophyAction($slug, $id)
    {} // "delete_organization_trophy" [DELETE] /organization/{slug}/trophy/{id}

    public function newTrophyAction($slug)
    {} // "new_organization_trophy"   [GET] /organization/{slug}/trophy/new

    public function editTrophyAction($slug, $id)
    {} // "edit_organization_trophy"   [GET] /organization/{slug}/trophy/{id}/edit

}