<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\Config\Trophy;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/trophy")
 * @NamePrefix("planbook_rest_trophy_")
 *
 * @RouteResource("Trophy")
 */
class TrophyController extends FOSRestController
{

    public function getTrophiesAction($orgSlug)
    {
        $trophyManager = $this->get('trophy_manager');
        $orgManager = $this->get('organization_manager');

        $org = $orgManager->findBySlug($orgSlug);
        $trophies = $trophyManager->findAllByOrganization($org);

        $view = $this->view($trophies, 200)
            ->setTemplate("AppBundle:Trophy:getTrophies.html.twig")
            ->setTemplateVar('trophies')
        ;

        return $this->handleView($view);
    } // "get_organization_trophies"   [GET] /organization/{orgSlug}/trophy

    public function getTrophyAction($orgSlug, $id)
    {
        $trophyManager = $this->get('trophy_manager');

        $trophy = $trophyManager->findById($id);

        $view = $this->view($trophy, 200)
            ->setTemplate("AppBundle:Trophy:getTrophy.html.twig")
            ->setTemplateVar('trophy')
        ;

        return $this->handleView($view);
    } // "get_organization_trophy"    [GET] /organization/{orgSlug}/trophy/{id}

    public function deleteTrophyAction($orgSlug, $id)
    {} // "delete_organization_trophy" [DELETE] /organization/{orgSlug}/trophy/{id}

    public function newTrophyAction($orgSlug)
    {
        $organizationManager = $this->get('organization_manager');
        $org = $organizationManager->findBySlug($orgSlug);

        $newTrophy = new Trophy();
        $newTrophy->setOrganization($org);
        $newTrophy->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newTrophy);
        $em->flush();

        $view = $this->view($newTrophy, 200)
            ->setTemplate("AppBundle:Trophy:newTrophy.html.twig")
            ->setTemplateVar('trophy')
        ;

        return $this->handleView($view);
    } // "new_organization_trophy"   [GET] /organization/{orgSlug}/trophy/new

    public function editTrophyAction($orgSlug, $id)
    {
        $trophyManager = $this->get('trophy_manager');

        $trophy = $trophyManager->findById($id);

        $view = $this->view($trophy, 200)
            ->setTemplate("AppBundle:Trophy:postTrophy.html.twig")
            ->setTemplateVar('trophy')
        ;

        return $this->handleView($view);
    } // "edit_organization_trophy"   [GET] /organization/{orgSlug}/trophy/{id}/edit

}