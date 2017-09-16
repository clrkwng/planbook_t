<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 6:10 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Config\Trophy;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class TrophyAdmin extends AbstractAdmin
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
            ->with('Trophy')
                ->add('name', 'text', array(
                    'label' => 'Name'
                ))
                ->add('enabled', 'checkbox', array(
                    'label' => 'Active'
                ))
                ->add('image', 'entity', array(
                    'class' => 'AppBundle\Entity\Organization\Config\Image',
                    'label' => 'Picture'
                ))
            ->end()

            ->with('Next Trophy')
                ->add('next_trophy', 'entity', array(
                    'class' => 'AppBundle\Entity\Organization\Config\Trophy',
                    'label' => 'Next Trophy',
                    'help' => 'The next trophy to be received'
                ))
                ->add('amount_needed_next', 'integer', array(
                    'label' => 'Increment Amount',
                    'help' => 'How many of this trophy is needed to receive the next trophy'
                ))
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
            ->add('name')
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
            ->add('image.name')
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
            ->add('enabled')
            ->add('image.name')
            ->add('next_trophy.name')
            ->add('amount_needed_next')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Trophy
            ? $object->getName()
            : 'Trophy'; // shown in the breadcrumb on the create view
    }

}