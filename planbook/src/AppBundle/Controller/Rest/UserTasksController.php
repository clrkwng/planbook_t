<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/9/2017
 * Time: 3:58 PM
 */

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Organization\Config\Trophy;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Entity\Organization\User\Achievement;
use AppBundle\Entity\Organization\User\Prize;
use AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeatSingle;
use AppBundle\Entity\Organization\User\Task\Single\TaskSingle;
use AppBundle\Entity\Organization\User\Task\Task;
use AppBundle\Entity\Organization\User\User;
use AppBundle\Form\Rest\OrgTrophyType;
use AppBundle\Form\Rest\OrgUsersType;
use AppBundle\Form\Rest\UserAchievementsType;
use AppBundle\Form\Rest\UserMarketType;
use AppBundle\Repository\Organization\Config\TrophyRepository;
use AppBundle\Repository\Organization\OrganizationRepository;
use AppBundle\Repository\Organization\User\AchievementRepository;
use AppBundle\Repository\Organization\User\PrizeRepository;
use AppBundle\Repository\Organization\User\Task\Repeat\TaskRepeatSingleRepository;
use AppBundle\Repository\Organization\User\Task\Single\TaskSingleRepository;
use AppBundle\Repository\Organization\User\UserRepository;
use AppBundle\Rest\Response\OrgTrophyResponse;
use AppBundle\Rest\Response\OrgUsersResponse;
use AppBundle\Rest\Response\UserAchievementResponse;
use AppBundle\Rest\Response\UserMarketResponse;
use AppBundle\Rest\Response\UserTasksResponse;
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
 * @RouteResource("UserTasks")
 */
class UserTasksController extends FOSRestController
{

    /**
     * Get the list of tasks.
     *
     * @param string $userId integer with the user id (requires param_fetcher_listener: force)
     *
     * @return UserTasksResponse
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

        /** @var TaskRepeatSingleRepository $repeatTaskManager */
        $repeatTaskManager = $this->get('task_repeat_single_manager');

        /** @var TaskRepeatSingle $repeatTasks*/
        $repeatTasks = $repeatTaskManager->findAllByUser($user);

        /** @var TaskSingleRepository $singleTaskManager */
        $singleTaskManager = $this->get('task_single_manager');

        /** @var TaskSingle $singleTasks*/
        $singleTasks = $singleTaskManager->findAllByUser($user);

        return new UserTasksResponse($user->getId(), $singleTasks, $repeatTasks);
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
        return $this->getForm(null, 'planbook_rest_user_post_tasks');
    }

    /**
     * Display the edit form.
     *
     * @param string $task path
     *
     * @return Form form instance
     *
     * @View(template="AppBundle:Rest:newTask.html.twig")
     */
    public function editAction($task)
    {
        $task = $this->createTask($task);
        return $this->getForm($task);
    }

    private function createTask($task)
    {
        if($task == NULL){
            $task = new Task();
        }

        /* Set other default achievement values here */

        return $task;
    }

    /**
     * Get the achievement.
     *
     * @param string $task path
     *
     * @return \FOS\RestBundle\View\View
     *
     * @View()
     */
    public function getAction($task)
    {
        $task = $this->createTask($task);
        // using explicit View creation
        return $this->view(array('task' => $task));
    }

    /**
     * Get a Form instance.
     *
     * @param Task|null $task
     * @param string|null  $routeName
     *
     * @return Form
     */
    protected function getForm($task = null, $routeName = null)
    {
        $options = array();
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName);
        }
        if (null === $task) {
            $task = new Task();
        }
        return $this->createForm(new UserMarketType(), $task, $options);
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
            $this->get('session')->getFlashBag()->set('task', 'Task is stored at path: '.$form->getData()->getPath());
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