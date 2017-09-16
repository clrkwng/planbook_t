<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 5:39 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Config\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class ImageAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     *
     * Fields to be shown on create/edit forms
     *
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->add('name', 'text', array(
                'label' => 'Name'
            ))
            ->add('description', 'text', array(
                'label' => 'Description'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Active'
            ))
            ->add('picture', 'text', array(
                'label' => 'Upload'
            ))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     *
     * Fields to be shown on filter forms
     *
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('picture')

        ;
    }

    /**
     * @param ListMapper $listMapper
     *
     * Fields to be shown on lists
     *
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('slug')
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('picture')

        ;
    }

    /**
     * @param ShowMapper $showMapper
     *
     * Fields to be shown on show action
     *
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('slug')
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('picture')

        ;
    }

    public function toString($object)
    {
        return $object instanceof Image
            ? $object->getName()
            : 'Image'; // shown in the breadcrumb on the create view
    }

}