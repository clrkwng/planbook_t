<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/8/2017
 * Time: 6:14 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Organization\Config\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array('label' => 'Image (.JPEG/.PNG file)'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Image::class,
        ));
    }
}