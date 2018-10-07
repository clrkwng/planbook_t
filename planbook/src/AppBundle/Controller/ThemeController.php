<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\System\Theme\Theme;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/*
 * @Prefix("planbook/rest/theme")
 * @NamePrefix("planbook_rest_theme_")
 *
 * @RouteResource("Theme")
 */
class ThemeController extends FOSRestController
{
    public function getThemesAction($orgSlug, $userId)
    {
        $themeManager = $this->get('theme_manager');
        $userManager = $this->get('user_manager');

        $user = $userManager->findById($userId);
        $themes = $themeManager->findAllByUser($user);

        $view = $this->view($themes, 200)
            ->setTemplate("AppBundle:Theme:getThemes.html.twig")
            ->setTemplateVar('themes')
        ;

        return $this->handleView($view);
    } // "get_organization_user_themes"   [GET] /organization/{orgSlug}/user/{userId}/theme

    public function getThemeAction($orgSlug, $userId, $id)
    {
        $themeManager = $this->get('theme_manager');

        $theme = $themeManager->findbyId($id);

        $view = $this->view($theme, 200)
            ->setTemplate("AppBundle:Theme:getTheme.html.twig")
            ->setTemplateVar('theme')
        ;

        return $this->handleView($view);
    } // "get_organization_user_theme"    [GET] /organization/{orgSlug}/user/{userId}/theme/{id}

    public function deleteThemeAction($orgSlug, $userId, $id)
    {} // "delete_organization_user_theme" [DELETE] /organization/{orgSlug}/user/{userId}/theme/{id}

    public function newThemeAction($orgSlug, $userId)
    {
        $newTheme = new Theme();
        $newTheme->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newTheme);
        $em->flush();

        $view = $this->view($newTheme, 200)
            ->setTemplate("AppBundle:Theme:newTheme.html.twig")
            ->setTemplateVar('task')
        ;

        return $this->handleView($view);
    } // "new_organization_user_theme"   [GET] /organization/{orgSlug}/user/{userId}/theme/new

    public function editThemeAction($orgSlug, $userId, $id)
    {
        $themeManager = $this->get('theme_manager');

        $theme = $themeManager->findbyId($id);

        $view = $this->view($theme, 200)
            ->setTemplate("AppBundle:Theme:postTheme.html.twig")
            ->setTemplateVar('theme')
        ;

        return $this->handleView($view);
    } // "edit_organization_user_theme"   [GET] /organization/{orgSlug}/user/{userId}/theme/{id}/edit

}