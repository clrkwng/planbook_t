<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/9/2017
 * Time: 3:57 PM
 */

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Organization\Config\Trophy;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Entity\Organization\User\Achievement;
use AppBundle\Entity\Organization\User\User;
use AppBundle\Form\Rest\OrgTrophyType;
use AppBundle\Form\Rest\OrgUsersType;
use AppBundle\Form\Rest\UserAchievementsType;
use AppBundle\Repository\Organization\Config\TrophyRepository;
use AppBundle\Repository\Organization\OrganizationRepository;
use AppBundle\Repository\Organization\User\AchievementRepository;
use AppBundle\Repository\Organization\User\UserRepository;
use AppBundle\Rest\Response\OrgTrophyResponse;
use AppBundle\Rest\Response\OrgUsersResponse;
use AppBundle\Rest\Response\UserAchievementResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Prefix("planbook/rest/user")
 * @NamePrefix("planbook_rest_user")
 * @RouteResource("UserAchievements")
 */
class UserAchievementsController extends FOSRestController
{

    /**
     * Get the list of achievements.
     *
     * @param string $userId integer with the user id (requires param_fetcher_listener: force)
     *
     * @return UserAchievementResponse
     *
     * @View()
     * @QueryParam(name="userId", requirements="\d+", default="1", description="Id of the user.")
     */
    public function cgetAction($userId)
    {

        /** @var UserRepository $userManager */
        $userManager = $this->get('user_manager');

        /** @var User $user */
        $user = $userManager->findById($userId);

        /** @var AchievementRepository $achievementManager */
        $achievementManager = $this->get('user_manager');

        /** @var Achievement $achievements */
        $achievements = $achievementManager->findAllByUser($user);

        return new UserAchievementResponse($user->getId(), $achievements);
    }

    /**
     * Display the form.
     *
     * @return Form form instance
     *
     * @View()
     */
    public function newAction()
    {
        return $this->getForm(null, 'planbook_rest_user_post_achievements');
    }

    /**
     * Display the edit form.
     *
     * @param string $achievement path
     *
     * @return Form form instance
     *
     * @View(template="AppBundle:Rest:newAchievement.html.twig")
     */
    public function editAction($achievement)
    {
        $achievement = $this->createAchievement($achievement);
        return $this->getForm($achievement);
    }

    private function createAchievement($achievement)
    {
        if($achievement == NULL){
            $achievement = new Achievement();
        }

        /* Set other default achievement values here */

        return $achievement;
    }

    /**
     * Get the achievement.
     *
     * @param string $achievement path
     *
     * @return \FOS\RestBundle\View\View
     *
     * @View()
     */
    public function getAction($achievement)
    {
        $achievement = $this->createAchievement($achievement);
        // using explicit View creation
        return $this->view(array('achievement' => $achievement));
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
        return $this->createForm(new UserAchievementsType(), $achievement, $options);
    }

    /**
     * Create a new resource.
     *
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     *
     * @View()
     */
    public function cpostAction(Request $request)
    {
        $form = $this->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('achievement', 'Achievement is stored at path: '.$form->getData()->getPath());
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