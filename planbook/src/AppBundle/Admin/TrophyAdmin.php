<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 6:10 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Config\Image;
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
                ->add('image', 'sonata_type_admin', array(
                    'label' => 'Picture',
                    'delete' => false
                ))
            ->end()

            ->with('Next Trophy')
                ->add('next_trophy', 'sonata_type_admin', array(
                    'label' => 'Next Trophy',
                    'help' => 'The next trophy to be received',
                    'delete' => false
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
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('enabled', null, array(
                'editable' => true,
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
            ->add('image.fileName', 'text', array(
                'label' => 'Image'
            ))
            ->add('enabled', null, array(
                'editable' => true,
                'label' => 'Enabled'
            ))
            ->add('next_trophy.name', 'text', array(
                'label' => 'Next Trophy'
            ))
            ->add('amount_needed_next', 'integer', array(
                'label' => 'Amount Needed'
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
        return $object instanceof Trophy
            ? $object->getName()
            : 'Trophy'; // shown in the breadcrumb on the create view
    }

}