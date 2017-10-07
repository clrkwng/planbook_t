<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\Achievement;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;

class AchievementController extends FOSRestController
{

    public function getAchievementsAction($orgSlug, $userId)
    {
        $achievementManager = $this->get('achievement_manager');
        $userManager = $this->get('user_manager');
        $user = $userManager->findById($userId);
        $achievements = $achievementManager->findAllByUser($user);

        $view = $this->view($achievements, 200)
            ->setTemplate("AppBundle:Achievement:getAchievements.html.twig")
            ->setTemplateVar('achievements')
        ;

        return $this->handleView($view);
    } // "get_organization_user_achievements"   [GET] /organization/{orgSlug}/user/{userId}/achievement

    public function getAchievementAction($orgSlug, $userId, $id)
    {
        $achievementManager = $this->get('achievement_manager');
        $achievement = $achievementManager->findById($id);

        $view = $this->view($achievement, 200)
            ->setTemplate("AppBundle:Achievement:getAchievement.html.twig")
            ->setTemplateVar('achievement')
        ;

        return $this->handleView($view);
    } // "get_organization_user_achievement"    [GET] /organization/{orgSlug}/user/{userId}/achievement/{id}

    public function deleteAchievementAction($orgSlug, $userId, $id)
    {

    } // "delete_organization_user_achievement" [DELETE] /organization/{orgSlug}/user/{userId}/achievement/{id}

    public function newAchievementAction($userId, $trophyId)
    {
        $userManager = $this->get('user_manager');
        $trophyManager = $this->get('trophy_manager');

        $user = $userManager->findById($userId);
        $trophy = $trophyManager->findById($trophyId);

        $newAchievement = new Achievement();
        $newAchievement->setUser($user);
        $newAchievement->setTrophy($trophy);
        $newAchievement->setQuantity(0);
        $newAchievement->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newAchievement);
        $em->flush();

        $view = $this->view($newAchievement, 200)
            ->setTemplate("AppBundle:Achievement:newAchievement.html.twig")
            ->setTemplateVar('achievement')
        ;

        return $this->handleView($view);

    } // "new_organization_user_achievement"   [GET] /organization/{orgSlug}/user/{userId}/achievement/new

    public function editAchievementAction($orgSlug, $userId, $id)
    {
        $achievementManager = $this->get('achievement_manager');
        $achievement = $achievementManager->findById($id);

        $view = $this->view($achievement, 200)
            ->setTemplate("AppBundle:Achievement:postAchievement.html.twig")
            ->setTemplateVar('achievement')
        ;

        return $this->handleView($view);
    } // "edit_organization_user_achievement"   [GET] /organization/{orgSlug}/user/{userId}/achievement/{id}/edit

}