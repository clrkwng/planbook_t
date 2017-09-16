<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 6:07 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\User\Prize;
use AppBundle\Entity\Organization\User\Task\Common\Priority;
use AppBundle\Entity\Organization\User\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class PriorityAdmin extends AbstractAdmin
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
            ->add('completion_points', 'integer', array(
                'label' => 'Completion Points',
                'help' => 'How many will be received for completing a task of this priority'
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
            ->add('completion_points')
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
            ->add('completion_points')
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
            ->add('completion_points')
            ->add('enabled')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Priority
            ? $object->getName()
            : 'Priority'; // shown in the breadcrumb on the create view
    }

}