<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function getCategoriesAction($slug)
    {} // "get_organization_categories"   [GET] /organization/{slug}/category

    public function getCategoryAction($slug, $id)
    {} // "get_organization_category"    [GET] /organization/{slug}/category/{id}

    public function deleteCategoryAction($slug, $id)
    {} // "delete_organization_category" [DELETE] /organization/{slug}/category/{id}

    public function newCategoryAction($slug)
    {} // "new_organization_category"   [GET] /organization/{slug}/category/new

    public function editCategoryAction($slug, $id)
    {} // "edit_organization_category"   [GET] /organization/{slug}/category/{id}/edit
}