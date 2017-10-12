<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\User\Task\Task;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/task")
 * @NamePrefix("planbook_rest_task_")
 *
 * @RouteResource("Task")
 */
class TaskController extends FOSRestController
{

    public function getTasksAction($orgSlug, $userId)
    {
        $taskManager = $this->get('task_manager');
        $userManager = $this->get('user_manager');

        $user = $userManager->findById($userId);
        $tasks = $taskManager->findAllByUser($user);

        $view = $this->view($tasks, 200)
            ->setTemplate("AppBundle:Task:getTasks.html.twig")
            ->setTemplateVar('tasks')
        ;

        return $this->handleView($view);
    } // "get_organization_user_tasks"   [GET] /organization/{orgSlug}/user/{userId}/task

    public function getTaskAction($orgSlug, $userId, $id)
    {
        $taskManager = $this->get('task_manager');

        $task = $taskManager->findById($id);

        $view = $this->view($task, 200)
            ->setTemplate("AppBundle:Task:getTask.html.twig")
            ->setTemplateVar('task')
        ;

        return $this->handleView($view);
    } // "get_organization_user_task"    [GET] /organization/{orgSlug}/user/{userId}/task/{id}

    public function deleteTaskAction($orgSlug, $userId, $id)
    {} // "delete_organization_user_task" [DELETE] /organization/{orgSlug}/user/{userId}/task/{id}

    public function newTaskAction($orgSlug, $userId)
    {
        $userManager = $this->get('user_manager');
        $user = $userManager->findById($userId);

        $newTask = new Task();
        $newTask->setEnabled(true);
        $newTask->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newTask);
        $em->flush();

        $view = $this->view($newTask, 200)
            ->setTemplate("AppBundle:Task:newTask.html.twig")
            ->setTemplateVar('task')
        ;

        return $this->handleView($view);
    } // "new_organization_user_task"   [GET] /organization/{orgSlug}/user/{userId}/task/new

    public function editTaskAction($orgSlug, $userId, $id)
    {
        $taskManager = $this->get('task_manager');

        $task = $taskManager->findById($id);

        $view = $this->view($task, 200)
            ->setTemplate("AppBundle:Task:postTask.html.twig")
            ->setTemplateVar('task')
        ;

        return $this->handleView($view);
    } // "edit_organization_user_task"   [GET] /organization/{orgSlug}/user/{userId}/task/{id}/edit


}