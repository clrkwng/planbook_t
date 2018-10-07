<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/user")
 * @NamePrefix("planbook_rest_user_")
 *
 * @RouteResource("User")
 */
class UserController extends FOSRestController
{

    public function getUsersAction($orgSlug)
    {
        $userManager = $this->get('user_manager');
        $orgManager = $this->get('organization_manager');

        $org = $orgManager->findBySlug($orgSlug);
        $users = $userManager->findAllByOrganization($org);

        $view = $this->view($users, 200)
            ->setTemplate("AppBundle:User:getUsers.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    } // "get_organization_users"   [GET] /organization/{orgSlug}/user

    public function getUserAction($orgSlug, $id)
    {
        $userManager = $this->get('user_manager');

        $user = $userManager->findById($id);

        $view = $this->view($user, 200)
            ->setTemplate("AppBundle:User:getUser.html.twig")
            ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    } // "get_organization_user"    [GET] /organization/{orgSlug}/user/{id}

    public function deleteUserAction($orgSlug, $id)
    {} // "delete_organization_user" [DELETE] /organization/{orgSlug}/user/{id}

    public function newUserAction($orgSlug)
    {
        $organizationManager = $this->get('organization_manager');
        $org = $organizationManager->findBySlug($orgSlug);

        $newUser = new User();
        $newUser->setOrganization($org);
        $newUser->setTotalPoints(0);
        $newUser->setTrophyPoints(0);
        $newUser->setPrizePoints(0);
        $newUser->addRole("ROLE_USER");
        $newUser->setEnabled(true);


        $em = $this->getDoctrine()->getManager();
        $em->persist($newUser);
        $em->flush();

        $view = $this->view($newUser, 200)
            ->setTemplate("AppBundle:User:newUser.html.twig")
            ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    } // "new_organization_user"   [GET] /organization/{orgSlug}/user/new

    public function editUserAction($orgSlug, $id)
    {
        $userManager = $this->get('user_manager');

        $user = $userManager->findById($id);

        $view = $this->view($user, 200)
            ->setTemplate("AppBundle:User:postUser.html.twig")
            ->setTemplateVar('user')
        ;

        return $this->handleView($view);
    } // "edit_organization_user"   [GET] /organization/{orgSlug}/user/{id}/edit

}