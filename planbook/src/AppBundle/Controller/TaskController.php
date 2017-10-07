<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:17 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller
{

    public function getTasksAction($slug, $userId)
    {} // "get_organization_user_tasks"   [GET] /organization/{slug}/user/{userId}/task

    public function getTaskAction($slug, $userId, $id)
    {} // "get_organization_user_task"    [GET] /organization/{slug}/user/{userId}/task/{id}

    public function deleteTaskAction($slug, $userId, $id)
    {} // "delete_organization_user_task" [DELETE] /organization/{slug}/user/{userId}/task/{id}

    public function newTaskAction($slug, $userId)
    {} // "new_organization_user_task"   [GET] /organization/{slug}/user/{userId}/task/new

    public function editTaskAction($slug, $userId, $id)
    {} // "edit_organization_user_task"   [GET] /organization/{slug}/user/{userId}/task/{id}/edit


}