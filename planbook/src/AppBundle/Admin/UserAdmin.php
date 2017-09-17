<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 10:03 AM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Config\Image;
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
            ->add('enabled', null, array(
                'label' => 'Enabled'
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
            ->add('username', null, array(
                'label' => 'Username'
            ))
            ->add('email', null, array(
                'label' => 'Email Address',
                'required' => false
            ))
            ->add('total_points', null, array(
                'label' => 'Total Points'
            ))
            ->add('trophy_points', null, array(
                'label' => 'Trophy Points'
            ))
            ->add('prize_points', null, array(
                'label' => 'Prize Points'
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
            ->addIdentifier('username', 'text', array(
                'label' => 'Username'
            ))
            ->add('email', 'text', array(
                'label' => 'Email Address'
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
            ->add('username', 'text', array(
                'label' => 'Username'
            ))
            ->add('email', 'text', array(
                'label' => 'Email Address'
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
            ->add('enabled', null, array(
                'label' => 'Enabled'
            ))
        ;
    }

    public function prePersist($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    public function preUpdate($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    private function manageEmbeddedImageAdmins($page)
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldDescription->getType() === 'sonata_type_admin' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'AppBundle\Entity\Image'
            ) {
                $getter = 'get'.$fieldName;
                $setter = 'set'.$fieldName;

                /** @var Image $image */
                $image = $page->$getter();

                if ($image) {
                    if ($image->getFile()) {
                        // update the Image to trigger file management
                        $image->refreshUpdated();
                    } elseif (!$image->getFile() && !$image->getFilename()) {
                        // prevent Sf/Sonata trying to create and persist an empty Image
                        $page->$setter(null);
                    }
                }
            }
        }
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getUsername()
            : 'User'; // shown in the breadcrumb on the create view
    }
}