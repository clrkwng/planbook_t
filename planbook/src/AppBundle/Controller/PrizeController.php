<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\Prize;
use AppBundle\Entity\Organization\User\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;

class PrizeController extends FOSRestController
{

    public function getPrizesAction($orgSlug, $userId)
    {
        $prizeManager = $this->get('prize_manager');
        $userManager = $this->get('user_manager');

        $user = $userManager->findById($userId);
        $prizes = $prizeManager->findAllByUser($user);

        $view = $this->view($prizes, 200)
            ->setTemplate("AppBundle:Prize:getPrizes.html.twig")
            ->setTemplateVar('prizes')
        ;

        return $this->handleView($view);
    } // "get_organization_user_prizes"   [GET] /organization/{orgSlug}/user/{userId}/prize

    public function getPrizeAction($orgSlug, $userId, $id)
    {
        $prizeManager = $this->get('prize_manager');

        $prize = $prizeManager->findById($id);

        $view = $this->view($prize, 200)
            ->setTemplate("AppBundle:Prize:getPrize.html.twig")
            ->setTemplateVar('prize')
        ;

        return $this->handleView($view);
    } // "get_organization_user_prize"    [GET] /organization/{orgSlug}/user/{userId}/prize/{id}

    public function deletePrizeAction($orgSlug, $userId, $id)
    {} // "delete_organization_user_prize" [DELETE] /organization/{orgSlug}/user/{userId}/prize/{id}

    public function newPrizeAction($orgSlug, $userId)
    {
        $userManager = $this->get('user_manager');
        $user = $userManager->findById($userId);

        $newPrize = new Prize();
        $newPrize->setEnabled(true);
        $newPrize->setUser($user);
        $newPrize->setPrice(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newPrize);
        $em->flush();

        $view = $this->view($newPrize, 200)
            ->setTemplate("AppBundle:Prize:newPrize.html.twig")
            ->setTemplateVar('prize')
        ;

        return $this->handleView($view);
    } // "new_organization_user_prize"   [GET] /organization/{orgSlug}/user/{userId}/prize/new

    public function editPrizeAction($orgSlug, $userId, $id)
    {
        $prizeManager = $this->get('prize_manager');

        $prize = $prizeManager->findById($id);

        $view = $this->view($prize, 200)
            ->setTemplate("AppBundle:Prize:postPrize.html.twig")
            ->setTemplateVar('prize')
        ;

        return $this->handleView($view);
    } // "edit_organization_user_prize"   [GET] /organization/{orgSlug}/user/{userId}/prize/{id}/edit

}