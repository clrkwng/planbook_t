<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\Task\Common\Priority;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/priority")
 * @NamePrefix("planbook_rest_priority_")
 *
 * @RouteResource("Priority")
 */
class PriorityController extends FOSRestController
{
    public function getPrioritiesAction($orgSlug)
    {
        $priorityManager = $this->get('priority_manager');
        $organizationManager = $this->get('organization_manager');

        $org = $organizationManager->findBySlug($orgSlug);
        $priorities = $priorityManager->findAllByOrganization($org);

        $view = $this->view($priorities, 200)
            ->setTemplate("AppBundle:Priority:getPriorities.html.twig")
            ->setTemplateVar('priorities')
        ;

        return $this->handleView($view);
    } // "get_organization_priorities"   [GET] /organization/{orgSlug}/priority

    public function getPriorityAction($orgSlug, $id)
    {
        $priorityManager = $this->get('priority_manager');

        $priority = $priorityManager->findById($id);

        $view = $this->view($priority, 200)
            ->setTemplate("AppBundle:Priority:getPriority.html.twig")
            ->setTemplateVar('priority')
        ;

        return $this->handleView($view);
    } // "get_organization_priority"    [GET] /organization/{orgSlug}/priority/{id}

    public function deletePriorityAction($orgSlug, $id)
    {} // "delete_organization_priority" [DELETE] /organization/{orgSlug}/priority/{id}

    public function newPriorityAction($orgSlug)
    {
        $organizationManager = $this->get('organization_manager');
        $org = $organizationManager->findBySlug($orgSlug);

        $newPriority = new Priority();
        $newPriority->setOrganization($org);
        $newPriority->setEnabled(true);
        $newPriority->setCompletionPoints(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newPriority);
        $em->flush();

        $view = $this->view($newPriority, 200)
            ->setTemplate("AppBundle:Prize:newPriority.html.twig")
            ->setTemplateVar('priority')
        ;

        return $this->handleView($view);
    } // "new_organization_priority"   [GET] /organization/{orgSlug}/priority/new

    public function editPriorityAction($orgSlug, $id)
    {
        $priorityManager = $this->get('priority_manager');

        $priority = $priorityManager->findById($id);

        $view = $this->view($priority, 200)
            ->setTemplate("AppBundle:Priority:postPriority.html.twig")
            ->setTemplateVar('priority')
        ;

        return $this->handleView($view);
    } // "edit_organization_priority"   [GET] /organization/{orgSlug}/priority/{id}/edit

}