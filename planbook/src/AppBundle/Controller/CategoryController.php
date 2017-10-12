<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\Task\Common\Category;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/category")
 * @NamePrefix("planbook_rest_category_")
 *
 * @RouteResource("Category")
 */
class CategoryController extends FOSRestController
{
    public function getCategoriesAction($orgSlug)
    {
        $categoryManager = $this->get('category_manager');
        $organizationManager = $this->get('organization_manager');

        $org = $organizationManager->findBySlug($orgSlug);
        $categories = $categoryManager->findAllByOrganization($org);

        $view = $this->view($categories, 200)
            ->setTemplate("AppBundle:Category:getCategories.html.twig")
            ->setTemplateVar('categories')
        ;

        return $this->handleView($view);
    } // "get_organization_categories"   [GET] /organization/{orgSlug}/category

    public function getCategoryAction($orgSlug, $id)
    {
        $categoryManager = $this->get('category_manager');

        $category = $categoryManager->findById($id);

        $view = $this->view($category, 200)
            ->setTemplate("AppBundle:Category:getCategory.html.twig")
            ->setTemplateVar('category')
        ;

        return $this->handleView($view);
    } // "get_organization_category"    [GET] /organization/{orgSlug}/category/{id}

    public function deleteCategoryAction($orgSlug, $id)
    {

    } // "delete_organization_category" [DELETE] /organization/{orgSlug}/category/{id}

    public function newCategoryAction($orgSlug)
    {
        $organizationManager = $this->get('organization_manager');
        $org = $organizationManager->findBySlug($orgSlug);

        $newCategory = new Category();
        $newCategory->setOrganization($org);
        $newCategory->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newCategory);
        $em->flush();

        $view = $this->view($newCategory, 200)
            ->setTemplate("AppBundle:Category:newCategory.html.twig")
            ->setTemplateVar('category')
        ;

        return $this->handleView($view);
    } // "new_organization_category"   [GET] /organization/{orgSlug}/category/new

    public function editCategoryAction($orgSlug, $id)
    {
        $categoryManager = $this->get('category_manager');

        $category = $categoryManager->findById($id);

        $view = $this->view($category, 200)
            ->setTemplate("AppBundle:Category:postCategory.html.twig")
            ->setTemplateVar('category')
        ;

        return $this->handleView($view);
    } // "edit_organization_category"   [GET] /organization/{orgSlug}/category/{id}/edit
}