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
use AppBundle\Entity\Organization\User\User;
use AppBundle\Form\Rest\OrgTrophyType;
use AppBundle\Form\Rest\OrgUsersType;
use AppBundle\Repository\Organization\Config\TrophyRepository;
use AppBundle\Repository\Organization\OrganizationRepository;
use AppBundle\Repository\Organization\User\UserRepository;
use AppBundle\Rest\Response\OrgTrophyResponse;
use AppBundle\Rest\Response\OrgUsersResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Prefix("planbook/rest/org")
 * @NamePrefix("planbook_rest_org")
 * @RouteResource("OrgUsers")
 */
class OrgUsersController extends FOSRestController
{

    /**
     * Get the list of users.
     *
     * @param string $orgId integer with the trophy id (requires param_fetcher_listener: force)
     *
     * @return OrgUsersResponse
     *
     * @View()
     * @QueryParam(name="orgId", requirements="\d+", default="1", description="Id of the organization.")
     */
    public function cgetAction($orgId)
    {

        /** @var OrganizationRepository $organizationManager */
        $organizationManager = $this->get('organization_manager');

        /** @var Organization $organization */
        $organization = $organizationManager->findById($orgId);

        /** @var UserRepository $userManager */
        $userManager = $this->get('user_manager');

        /** @var User $user */
        $users = $userManager->findAllByOrganization($organization);

        return new OrgUsersResponse($organization->getSlug(), $organization->getId(), $organization->getName(), $users);
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
        return $this->getForm(null, 'planbook_rest_org_post_users');
    }

    /**
     * Display the edit form.
     *
     * @param string $user path
     *
     * @return Form form instance
     *
     * @View(template="AppBundle:Rest:newUser.html.twig")
     */
    public function editAction($user)
    {
        $user = $this->createUser($user);
        return $this->getForm($user);
    }

    private function createUser($user)
    {
        if($user == NULL){
            $user = new User();
        }

        /* Set other default trophy values here */

        return $user;
    }

    /**
     * Get the user.
     *
     * @param string $user path
     *
     * @return \FOS\RestBundle\View\View
     *
     * @View()
     */
    public function getAction($user)
    {
        $user = $this->createUser($user);
        // using explicit View creation
        return $this->view(array('user' => $user));
    }

    /**
     * Get a Form instance.
     *
     * @param User|null $user
     * @param string|null  $routeName
     *
     * @return Form
     */
    protected function getForm($user = null, $routeName = null)
    {
        $options = array();
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName);
        }
        if (null === $user) {
            $user = new User();
        }
        return $this->createForm(new OrgUsersType(), $user, $options);
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
            $this->get('session')->getFlashBag()->set('user', 'User is stored at path: '.$form->getData()->getPath());
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