<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\Achievement;
use AppBundle\Form\UserAchievementType;
use AppBundle\Repository\Organization\User\AchievementRepository;
use AppBundle\Rest\Response\UserAchievementResponse;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/*
 * @Prefix("planbook/rest/achievement")
 * @NamePrefix("planbook_rest_achievement_")
 *
 * @RouteResource("Achievement")
 */
class AchievementController extends FOSRestController
{

    /**
     * Get the list of achievements.
     *
     * @param string $userId integer with the User ID (requires param_fetcher_listener: force)
     *
     * @return UserAchievementResponse
     *
     * @View()
     * @QueryParam(name="userId", requirements="\d+", default="1", description="Id of the User to retrieve all achievements for.")
     */
    public function getAchievementsAction($userId)
    {
        $achievementManager = $this->get('achievement_manager');
        $userManager = $this->get('user_manager');
        $user = $userManager->findById($userId);
        $achievements = $achievementManager->findAllByUser($user);

        return new UserAchievementResponse($userId, $achievements);
    } // "get_organization_user_achievements"   [GET] /organization/{orgSlug}/user/{userId}/achievement


    /**
     * Get the achievement.
     *
     * @param string $id integer with the achievement id (requires param_fetcher_listener: force)
     *
     * @return UserAchievementResponse
     *
     * @View()
     * @QueryParam(name="id", requirements="\d+", default="1", description="The Id of the achievement to fetch.")
     */
    public function getAchievementAction($id)
    {
        /** @var AchievementRepository $achievementManager */
        $achievementManager = $this->get('achievement_manager');

        /** @var Achievement $achievement */
        $achievement = $achievementManager->findById($id);

        $userId = $achievement->getUser()->getId();

        return new UserAchievementResponse($userId, $achievement);
    }

    public function deleteAchievementAction($orgSlug, $userId, $id)
    {

    }

    /**
     * Display the form.
     *
     * @return Form form instance
     *
     * @View()
     * @ApiDoc()
     */
    public function newAction()
    {
        return $this->getForm(null, 'planbook_rest_achievement_post_achievement');
    }

    /**
     * Get a Form instance.
     *
     * @param Achievement|null $achievement
     * @param string|null  $routeName
     *
     * @return Form
     */
    protected function getForm($achievement = null, $routeName = null)
    {
        $options = array();
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName);
        }
        if (null === $achievement) {
            $achievement = new Achievement();
        }
        return $this->createForm(new UserAchievementType(), $achievement, $options);
    }

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

    /**
     * Display the edit form.
     *
     * @param string $achievement path
     *
     * @return Form form instance
     *
     * @View(template="AppBundle:Achievement:new.html.twig")
     */
    public function editAchievementAction($achievement)
    {
        $achievement = $this->createAchievement($achievement);
        return $this->getForm($achievement);
    }

    private function createAchievement($achievement)
    {
        $text = $achievement;
        $achievement = new Achievement();

        return $achievement;
    }

    /**
     * Create a new resource.
     *
     * @param Request $request
     *
     * @return View view instance
     *
     * @View()
     */
    public function cpostAction(Request $request)
    {
        $form = $this->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('article', 'Article is stored at path: '.$form->getData()->getPath());
            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the newly created or updated resource url
            $view = $this->routeRedirectView('hello', array('name' => $form->getData()->getTitle()));
        } else {
            $view = $this->view($form);
        }
        // Note: this would normally not be necessary, just a "hack" to make the format selectable in the form
        $view->setFormat($form->getData()->format);
        return $view;
    }
}