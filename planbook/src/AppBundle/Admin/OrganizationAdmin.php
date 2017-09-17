<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 2:11 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Organization;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class OrganizationAdmin extends AbstractAdmin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array(
                'label' => 'Organization Name'
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array(
                'label' => 'Id'
            ))
            ->add('name', null, array(
                'label' => 'Organization Name'
            ))
            ->add('uuid', null, array(
                'label' => 'UUID'
            ))
        ;
    }

    // Fields to be shown on lists

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'text', array(
                'label' => 'Organization Name'
            ))
            ->add('uuid', 'text', array(
                'label' => 'UUID'
            ))
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', 'integer', array(
                'label' => 'Id'
            ))
            ->add('name', 'text', array(
                'label' => 'Organization Name'
            ))
            ->add('uuid', 'text', array(
                'label' => 'UUID'
            ))
        ;
    }

    /**
     * @param RouteCollection $collection
     *
     * Overridden to prevent users from creating more than one organization
     *
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        /* Removing the create route will disable creating new entities. It will also
         * remove the 'Add new' button in the list view.
         */
        $collection->remove('create');
    }

    public function toString($object)
    {
        return $object instanceof Organization
            ? $object->getName()
            : 'Organization'; // shown in the breadcrumb on the create view
    }

}