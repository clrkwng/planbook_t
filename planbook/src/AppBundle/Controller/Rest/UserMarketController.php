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
use AppBundle\Entity\Organization\User\Prize;
use AppBundle\Entity\Organization\User\User;
use AppBundle\Form\Rest\OrgTrophyType;
use AppBundle\Form\Rest\OrgUsersType;
use AppBundle\Form\Rest\UserAchievementsType;
use AppBundle\Form\Rest\UserMarketType;
use AppBundle\Repository\Organization\Config\TrophyRepository;
use AppBundle\Repository\Organization\OrganizationRepository;
use AppBundle\Repository\Organization\User\AchievementRepository;
use AppBundle\Repository\Organization\User\PrizeRepository;
use AppBundle\Repository\Organization\User\UserRepository;
use AppBundle\Rest\Response\OrgTrophyResponse;
use AppBundle\Rest\Response\OrgUsersResponse;
use AppBundle\Rest\Response\UserAchievementResponse;
use AppBundle\Rest\Response\UserMarketResponse;
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
 * @RouteResource("UserMarket")
 */
class UserMarketController extends FOSRestController
{

    /**
     * Get the list of prizes.
     *
     * @param string $userId integer with the user id (requires param_fetcher_listener: force)
     *
     * @return UserMarketResponse
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

        /** @var PrizeRepository $prizeManager */
        $prizeManager = $this->get('prize_manager');

        /** @var Prize $prizes*/
        $prizes = $prizeManager->findAllByUser($user);

        return new UserMarketResponse($user->getId(), $user->getPrizePoints(), $prizes);
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
        return $this->getForm(null, 'planbook_rest_user_post_prizes');
    }

    /**
     * Display the edit form.
     *
     * @param string $prize path
     *
     * @return Form form instance
     *
     * @View(template="AppBundle:Rest:newPrize.html.twig")
     */
    public function editAction($prize)
    {
        $prize = $this->createPrize($prize);
        return $this->getForm($prize);
    }

    private function createPrize($prize)
    {
        if($prize == NULL){
            $prize = new Prize();
        }

        /* Set other default achievement values here */

        return $prize;
    }

    /**
     * Get the achievement.
     *
     * @param string $prize path
     *
     * @return \FOS\RestBundle\View\View
     *
     * @View()
     */
    public function getAction($prize)
    {
        $prize = $this->createPrize($prize);
        // using explicit View creation
        return $this->view(array('prize' => $prize));
    }

    /**
     * Get a Form instance.
     *
     * @param Prize|null $prize
     * @param string|null  $routeName
     *
     * @return Form
     */
    protected function getForm($prize = null, $routeName = null)
    {
        $options = array();
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName);
        }
        if (null === $prize) {
            $prize = new Prize();
        }
        return $this->createForm(new UserMarketType(), $prize, $options);
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
            $this->get('session')->getFlashBag()->set('prize', 'Prize is stored at path: '.$form->getData()->getPath());
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