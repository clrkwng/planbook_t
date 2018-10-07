<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/13/2017
 * Time: 5:39 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Organization\Config\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class ImageAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     *
     * Fields to be shown on create/edit forms
     *
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        if($this->hasParentFieldDescription()) { // this Admin is embedded
            // $getter will be something like 'getlogoImage'
            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();

            // get hold of the parent object
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if ($parent) {
                /** @var Image $image */
                $image = $parent->$getter();
            } else {
                $image = null;
            }
        } else {
            $image = $this->getSubject();
        }

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        if ($image && ($webPath = $image->getWebPath())) {
            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$webPath.'" class="admin-preview" />';
            $fileFieldOptions['label'] = 'Image File';
        }

        $formMapper
            ->with("General")
                ->add('name', 'text', array(
                    'label' => 'Name'
                ))
                ->add('description', 'text', array(
                    'label' => 'Description',
                    'required' => false
                ))
                ->add('enabled', 'checkbox', array(
                    'label' => 'Enabled'
                ))
            ->end()
            ->with("Upload a New Image")
                ->add('file', 'file', $fileFieldOptions)
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
                'label' => 'Description'
            ))
            ->add('fileName', null, array(
                'label' => 'File Name'
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
            ->addIdentifier('name', 'text', array(
                'label' => 'Name'
            ))
            ->add('description', 'text', array(
                'label' => 'Description'
            ))
            ->add('fileName', 'text', array(
                'label' => 'File Name'
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
            ->add('fileName', 'text', array(
                'label' => 'File Name'
            ))
            ->add('enabled', 'checkbox', array(
                'editable' => true,
                'label' => 'Enabled'
            ))

        ;
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload(Image $image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    public function toString($object)
    {
        return $object instanceof Image
            ? $object->getName()
            : 'Image'; // shown in the breadcrumb on the create view
    }

}