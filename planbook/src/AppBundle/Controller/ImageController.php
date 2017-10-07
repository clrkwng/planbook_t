<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\Config\Image;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;

class ImageController extends FOSRestController
{

    public function getImagesAction($orgSlug)
    {
        $imageManager = $this->get('image_manager');
        $organizationManager = $this->get('organization_manager');

        $org = $organizationManager->findBySlug($orgSlug);
        $images = $imageManager->findAllByOrganization($org);

        $view = $this->view($images, 200)
            ->setTemplate("AppBundle:Image:getImages.html.twig")
            ->setTemplateVar('images')
        ;

        return $this->handleView($view);
    } // "get_organization_images"   [GET] /organization/{orgSlug}/image

    public function getImageAction($orgSlug, $id)
    {
        $imageManager = $this->get('image_manager');

        $image = $imageManager->findById($id);

        $view = $this->view($image, 200)
            ->setTemplate("AppBundle:Image:getImage.html.twig")
            ->setTemplateVar('image')
        ;

        return $this->handleView($view);
    } // "get_organization_image"    [GET] /organization/{orgSlug}/image/{id}

    public function deleteImageAction($orgSlug, $id)
    {

    } // "delete_organization_image" [DELETE] /organization/{orgSlug}/image/{id}

    public function newImageAction($orgSlug)
    {
        $organizationManager = $this->get('organization_manager');
        $org = $organizationManager->findBySlug($orgSlug);

        $newImage = new Image();
        $newImage->setOrganization($org);
        $newImage->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newImage);
        $em->flush();

        $view = $this->view($newImage, 200)
            ->setTemplate("AppBundle:Prize:newImage.html.twig")
            ->setTemplateVar('image')
        ;

        return $this->handleView($view);
    } // "new_organization_image"   [GET] /organization/{orgSlug}/image/new

    public function editImageAction($orgSlug, $id)
    {
        $imageManager = $this->get('image_manager');

        $image = $imageManager->findById($id);

        $view = $this->view($image, 200)
            ->setTemplate("AppBundle:Image:postImage.html.twig")
            ->setTemplateVar('image')
        ;

        return $this->handleView($view);
    } // "edit_organization_image"   [GET] /organization/{orgSlug}/image/{id}/edit

}