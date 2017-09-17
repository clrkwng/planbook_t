<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/16/2017
 * Time: 11:29 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Organization\User\Task\Repeat\TaskRepeat;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TaskRepeatAdmin extends AbstractAdmin
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
            ->tab("Base Task")
                ->with('')
                    ->add('task', 'entity', array(
                        'class' => 'AppBundle\Entity\Organization\User\Task\Task',
                        'label' => 'Task',
                        'mapped' => false
                    ))
                ->end()
                ->with("Override Inherited Properties")
                    ->add('name_ov', 'text', array(
                        'label' => 'Name',
                        'required' => false
                    ))
                    ->add('description_ov', 'text', array(
                        'label' => 'Description',
                        'required' => false
                    ))
                ->end()
            ->end()
            ->tab('Repeating Task Info')
                ->with("")
                    ->add('priority', 'entity', array(
                        'class' => 'AppBundle\Entity\Organization\User\Task\Common\Priority',
                        'label' => 'Priority'
                    ))
                    ->add('frequencies', 'entity', array(
                        'class' => 'AppBundle\Entity\Organization\User\Task\Repeat\Frequency',
                        'label' => 'Frequency',
                        'help' => 'When you plan to engage in this task'
                    ))
                ->end()
                ->with('')
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
            ->add('task.user.username', null, array(
                'label' => 'User'
            ))
            ->add('priority', null, array(
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
            ->add('user.username', null, array(
                'label' => 'User'
            ))
            ->add('priority', null, array(
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
            ->add('task.user.username', null, array(
                'label' => 'User'
            ))
            ->add('priority', null, array(
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
        return $object instanceof TaskRepeat
            ? $object->getNameOv()
            : 'TaskRepeat'; // shown in the breadcrumb on the create view
    }

}