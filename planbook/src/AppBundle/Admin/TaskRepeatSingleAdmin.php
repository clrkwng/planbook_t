<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/16/2017
 * Time: 11:42 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeatSingle;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TaskRepeatSingleAdmin extends AbstractAdmin
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
            ->tab("Configure Repeating Task Instance")
                ->with("Parent Repeating Task")
                    ->add('base_repeat_task', 'entity', array(
                        'class' => 'AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeat',
                        'label' => 'Task',
                        'mapped' => false
                    ))
                ->with("Override Inherited Properties")
                    ->add('name_ov', 'text', array(
                        'label' => 'Name',
                        'required' => false
                    ))
                    ->add('description_ov', 'text', array(
                        'label' => 'Description',
                        'required' => false
                    ))
                    ->add('priority_ov', 'entity', array(
                        'class' => 'AppBundle\Entity\Organization\User\Task\Common\Priority',
                        'label' => 'Priority',
                        'required' => false
                    ))
                ->end()
            ->end()
            ->tab("Repeating Task Info")
                ->with('')
                    ->add('deadline', 'datetime', array(
                        'label' => 'Deadline',
                        'help' => 'When this task is to be completed by'
                    ))
                    ->add('enabled', 'checkbox', array(
                        'label' => 'Enabled'
                    ))
                ->end()
            ->end()

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
            ->add('name_ov', null, array(
                'label' => 'Name'
            ))
            ->add('description_ov', null, array(
                'label' => 'Description'
            ))
            ->add('baseRepeatTask.task.user.username', null, array(
                'label' => 'User'
            ))
            ->add('deadline', null, array(
                'label' => 'Deadline'
            ))
            ->add('priority_ov', null, array(
                'label' => 'Priority'
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
            ->addIdentifier('name_ov', null, array(
                'label' => 'Name'
            ))
            ->add('description_ov', null, array(
                'label' => 'Description'
            ))
            ->add('baseRepeatTask.task.user.username', null, array(
                'label' => 'User'
            ))
            ->add('priority_ov', null, array(
                'label' => 'Priority'
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
            ->add('name_ov', null, array(
                'label' => 'Name'
            ))
            ->add('description_ov', null, array(
                'label' => 'Description'
            ))
            ->add('baseRepeatTask.task.user.username', null, array(
                'label' => 'User'
            ))
            ->add('priority_ov', null, array(
                'label' => 'Priority'
            ))
            ->add('enabled', null, array(
                'editable' => true,
                'label' => 'Enabled'
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof TaskRepeatSingle
            ? $object->getNameOv()
            : 'TaskRepeatSingle'; // shown in the breadcrumb on the create view
    }

}