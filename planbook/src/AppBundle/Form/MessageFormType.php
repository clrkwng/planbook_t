<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/11/2017
 * Time: 8:15 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('recipient', 'FOS\UserBundle\Form\Type\UsernameFormType');


    }

}