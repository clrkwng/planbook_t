<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/16/2017
 * Time: 11:25 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Organization\User\Task\Task;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TaskAdmin extends AbstractAdmin
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
                'label' => 'Description',
                'required' => false
            ))
            ->add('user', 'entity', array(
                'class' => 'AppBundle\Entity\Organization\User\User',
                'label' => 'User'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Enabled'
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
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('description', null, array(
                'label' => 'Description'
            ))
            ->add('user.username', null, array(
                'label' => 'User'
            ))
            ->add('enabled', null, array(
                'label' => 'Enabled'
            ))
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
            ->addIdentifier('name', null, array(
                'label' => 'Name'
            ))
            ->add('description', null, array(
                'label' => 'Description'
            ))
            ->add('user.username', null, array(
                'label' => 'User'
            ))
            ->add('enabled', null, array(
                'editable' => true,
                'label' => 'Enabled'
            ))
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
            ->add('name', 'text', array(
                'label' => 'Name'
            ))
            ->add('description', 'text', array(
                'label' => 'Description'
            ))
            ->add('user.username', 'text', array(
                'label' => 'User'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Enabled'
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof Task
            ? $object->getName()
            : 'Task'; // shown in the breadcrumb on the create view
    }
}