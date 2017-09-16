<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 6:21 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\User\Task\Common\Category;
use AppBundle\Entity\System\Theme\Color;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class CategoryAdmin extends AbstractAdmin
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
            ->add('image', 'entity', array(
                'class' => 'AppBundle\Entity\Organization\Config\Image',
                'label' => 'Picture'
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
            ->add('image.name')

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
            ->add('image.name')

        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Category
            ? $object->getName()
            : 'Category'; // shown in the breadcrumb on the create view
    }
}