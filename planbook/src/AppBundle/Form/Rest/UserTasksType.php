<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 10/9/2017
 * Time: 4:02 PM
 */

namespace AppBundle\Form\Rest;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTasksType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('format', 'choice', array('choices' => array('html' => 'html', 'json' => 'json', 'xml' => 'xml')))
            ->add('path', 'text')
            ->add('title', 'text')
            ->add('body', 'text')
        ;
    }
    public function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Organization\User\Task\Task',
        ));
    }
    public function getName()
    {
        return 'user_tasks';
    }

}