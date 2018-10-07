<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/6/2017
 * Time: 12:11 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization\Organization;
use AppBundle\Form\RegistrationType;
use AppBundle\Entity\Organization\User\User;
use AppBundle\Util\Organization\User\UserUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //Initialize a new Organization
            $org = new Organization();
            $org_uuid = \Ramsey\Uuid\Uuid::uuid4();
            $org->setUuid($org_uuid);
            $defaultOrgName = $user->getUsername() . "'s Organization";
            $org->setName($defaultOrgName);

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            //Generate and Set UUID
            $user_uuid = \Ramsey\Uuid\Uuid::uuid4();
            $user->setUuid($user_uuid);

            //Set intial values for an admin account in an organization
            $user->setTotalPoints(0);
            $user->setTrophyPoints(0);
            $user->setPrizePoints(0);
            $user->addRole("ROLE_ADMIN");
            $user->setEnabled(true);

            $org->addUser($user);
            $org->setEnabled(true);
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($org);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('fos_user_registration_check_email');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}