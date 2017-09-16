<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/8/2017
 * Time: 6:17 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Service\FileUploader;

class ImageController extends Controller
{
    /**
     * @Route("/image/new", name="app_image_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $image->getPicture();

            $fileName = $fileUploader->upload($file);

            // Update the 'picture' property to store the image file name
            // instead of its contents
            $image->setPicture($fileName);
            $image->setEnabled(true);

            //..other setters from the submitted form

            // ... persist the $image variable or any other work
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirect($this->generateUrl('app_image_list'));
        }

        return $this->render('image/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, Image $image){
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded image file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $image->setPicture(
                new File($this->getParameter('pictures_directory') . '/' . $image->getPicture())
            );
            //..other setters from the submitted form
            // ... persist the $image variable or any other work
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

        }

        return $this->render('image/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}