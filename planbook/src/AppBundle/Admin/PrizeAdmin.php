<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 5:56 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Config\Image;
use AppBundle\Entity\Organization\User\Prize;
use AppBundle\Entity\Organization\User\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class PrizeAdmin extends AbstractAdmin
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
            ->tab("General")
                ->with("Prize Info")
                    ->add('name', 'text', array(
                        'label' => 'Name'
                    ))
                    ->add('description', 'text', array(
                        'label' => 'Description',
                        'required' => false
                    ))

                ->end()
                ->with("Market Info")
                    ->add('user', 'entity', array(
                        'class' => 'AppBundle\Entity\Organization\User\User',
                        'label' => 'User'
                    ))
                    ->add('price', 'integer', array(
                        'label' => 'Price'
                    ))
                    ->add('enabled', 'checkbox', array(
                        'label' => 'Enabled'
                    ))
                ->end()
            ->end()
            ->tab("Picture")
                ->with("Upload Image")
                    ->add('image', 'sonata_type_admin', array(
                        'label' => 'Picture',
                        'delete' => false
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
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('description', null, array(
                'label' => 'Description',
                'required' => false
            ))
            ->add('price', null, array(
                'label' => 'Price'
            ))
            ->add('user.username', null, array(
                'label' => 'User'
            ))
            ->add('image.fileName', null, array(
                'label' => 'Image',
                'required' => false
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
            ->add('price', null, array(
                'label' => 'Price'
            ))
            ->add('user.username', null, array(
                'label' => 'User'
            ))
            ->add('image.fileName', null, array(
                'label' => 'Image'
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
            ->add('price', 'integer', array(
                'label' => 'Price'
            ))
            ->add('user.username', 'text', array(
                'label' => 'User'
            ))
            ->add('image.fileName', 'text', array(
                'label' => 'Image'
            ))
            ->add('enabled', 'checkbox', array(
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
        return $object instanceof Prize
            ? $object->getName()
            : 'Prize'; // shown in the breadcrumb on the create view
    }
}