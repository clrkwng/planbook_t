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
use AppBundle\Form\Rest\OrgTrophyType;
use AppBundle\Repository\Organization\Config\TrophyRepository;
use AppBundle\Repository\Organization\OrganizationRepository;
use AppBundle\Rest\Response\OrgTrophyResponse;
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
 * @RouteResource("OrgTrophies")
 */
class OrgTrophyController extends FOSRestController
{

    /**
     * Get the list of trophies.
     *
     * @param string $orgId integer with the trophy id (requires param_fetcher_listener: force)
     *
     * @return OrgTrophyResponse
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

        /** @var TrophyRepository $trophyManager */
        $trophyManager = $this->get('trophy_manager');

        /** @var Trophy $trophy */
        $trophies = $trophyManager->findAllByOrganization($organization);

        return new OrgTrophyResponse($organization->getSlug(), $organization->getId(), $trophies);
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
        return $this->getForm(null, 'planbook_rest_org_post_trophies');
    }

    /**
     * Display the edit form.
     *
     * @param string $trophy path
     *
     * @return Form form instance
     *
     * @View(template="AppBundle:Rest:newTrophy.html.twig")
     */
    public function editAction($trophy)
    {
        $trophy = $this->createTrophy($trophy);
        return $this->getForm($trophy);
    }

    private function createTrophy($trophy)
    {
        if($trophy == NULL){
            $trophy = new Trophy();
        }

        /* Set other default trophy values here */

        return $trophy;
    }

    /**
     * Get the trophy.
     *
     * @param string $trophy path
     *
     * @return \FOS\RestBundle\View\View
     *
     * @View()
     */
    public function getAction($trophy)
    {
        $trophy = $this->createTrophy($trophy);
        // using explicit View creation
        return $this->view(array('trophy' => $trophy));
    }

    /**
     * Get a Form instance.
     *
     * @param Trophy|null $trophy
     * @param string|null  $routeName
     *
     * @return Form
     */
    protected function getForm($trophy = null, $routeName = null)
    {
        $options = array();
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName);
        }
        if (null === $trophy) {
            $trophy = new Trophy();
        }
        return $this->createForm(new OrgTrophyType(), $trophy, $options);
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
            $this->get('session')->getFlashBag()->set('trophy', 'Trophy is stored at path: '.$form->getData()->getPath());
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