<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\Organization;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/organization")
 * @NamePrefix("planbook_rest_organization_")
 *
 * @RouteResource("Organization")
 */
class OrganizationController extends FOSRestController
{
    public function getOrganizationsAction()
    {
        $organizationManager = $this->get('organization_manager');
        $organizations = $organizationManager->findAllOrderedByName();

        $view = $this->view($organizations, 200)
            ->setTemplate("AppBundle:Organization:getOrganizations.html.twig")
            ->setTemplateVar('organizations')
        ;

        return $this->handleView($view);

    } // "get_organizations"   [GET] /organization

    public function getOrganizationAction($slug)
    {
        $organizationManager = $this->get('organization_manager');
        $organization = $organizationManager->findOrganizationBySlug($slug);

        $view = $this->view($organization, 200)
            ->setTemplate("AppBundle:Organization:getOrganization.html.twig")
            ->setTemplateVar('organization')
        ;

        return $this->handleView($view);
    } // "get_organization"   [GET] /organization/{slug}

    public function editOrganizationAction($slug)
    {
        $organizationManager = $this->get('organization_manager');
        $organization = $organizationManager->findOrganizationBySlug($slug);

        $view = $this->view($organization, 200)
            ->setTemplate("AppBundle:Organization:postOrganization.html.twig")
            ->setTemplateVar('organization')
        ;

        return $this->handleView($view);
    } // "edit_organization"   [GET] /organization/{slug}/edit

    public function newOrganizationAction()
    {
        //If the user is requesting to create a new organization,
        // redirect to the RegistrationController

        $view = $this->redirectView($this->generateUrl('user_registration'), 301);

        return $this->handleView($view);
    } // "new_organization"   [GET] /organization/new

}