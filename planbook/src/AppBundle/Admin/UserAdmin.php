<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 10:03 AM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\User\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class UserAdmin extends AbstractAdmin
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

            ->add('username', 'text', array(
                'label' => 'Username'
            ))
            ->add('email', 'text', array(
                'label' => 'Email Address'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Active'
            ))
            ->add('total_points', 'integer', array(
                'label' => 'Total Points'
            ))
            ->add('trophy_points', 'integer', array(
                'label' => 'Trophy Points'
            ))
            ->add('prize_points', 'integer', array(
                'label' => 'Prize Points'
            ))
            ->add('image', 'entity', array(
                'class' => 'AppBundle\Entity\Organization\Config\Image',
                'label' => 'Profile Picture'
            ))
            ->add('theme', 'entity', array(
                'class' => 'AppBundle\Entity\System\Theme\Theme',
                'label' => 'Theme'
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
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('total_points')
            ->add('trophy_points')
            ->add('prize_points')
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
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('total_points')
            ->add('trophy_points')
            ->add('prize_points')
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
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('total_points')
            ->add('trophy_points')
            ->add('prize_points')
        ;
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getUsername()
            : 'User'; // shown in the breadcrumb on the create view
    }
}