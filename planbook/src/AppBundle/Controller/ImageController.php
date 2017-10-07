<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/1/2017
 * Time: 12:16 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImageController extends Controller
{

    public function getImagesAction($slug)
    {} // "get_organization_images"   [GET] /organization/{slug}/image

    public function getImageAction($slug, $id)
    {} // "get_organization_image"    [GET] /organization/{slug}/image/{id}

    public function deleteImageAction($slug, $id)
    {} // "delete_organization_image" [DELETE] /organization/{slug}/image/{id}

    public function newImageAction($slug)
    {} // "new_organization_image"   [GET] /organization/{slug}/image/new

    public function editImageAction($slug, $id)
    {} // "edit_organization_image"   [GET] /organization/{slug}/image/{id}/edit

}