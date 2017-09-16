<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 5:54 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\System\Theme\Color;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ColorAdmin extends AbstractAdmin
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
            ->add('hex_value', 'text', array(
                'label' => 'Hex Value'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Active'
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
            ->add('hex_value')
            ->add('enabled')

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
            ->add('hex_value')
            ->add('enabled')

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
            ->add('hex_value')
            ->add('enabled')

        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Color
            ? $object->getName()
            : 'Color'; // shown in the breadcrumb on the create view
    }
}