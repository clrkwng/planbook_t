<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrganizationController extends Controller
{
    public function getOrganizationAction($slug)
    {} // "get_organization"   [GET] /organization/{slug}

    public function editOrganizationAction($slug)
    {} // "edit_organization"   [GET] /organization/{slug}/edit

    public function newOrganizationAction()
    {} // "new_organization"   [GET] /organization/new

}