<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PriorityController extends Controller
{
    public function getPrioritiesAction($slug)
    {} // "get_organization_priorities"   [GET] /organization/{slug}/priority

    public function getPriorityAction($slug, $id)
    {} // "get_organization_priority"    [GET] /organization/{slug}/priority/{id}

    public function deletePriorityAction($slug, $id)
    {} // "delete_organization_priority" [DELETE] /organization/{slug}/priority/{id}

    public function newPriorityAction($slug)
    {} // "new_organization_priority"   [GET] /organization/{slug}/priority/new

    public function editPriorityAction($slug, $id)
    {} // "edit_organization_priority"   [GET] /organization/{slug}/priority/{id}/edit

}