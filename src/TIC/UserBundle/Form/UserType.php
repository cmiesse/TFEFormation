<?php

namespace TIC\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TIC\UserBundle\Entity\User;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $data */
        $data = $builder->getData();

        $builder->add('username', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'user.username',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true

        ));

        $builder->add('email', 'email', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'user.email',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('plain_password', 'password', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'user.password',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => $data->getId() === null
        ));

        $builder->add('roles', 'choice', array(
            'attr'=>  array('class' => 'form-control search-select'),
            'label' => 'user.roles',
            'label_attr'=> array('class'=> 'control-label col-md-3'),
            'choices' => array(
                'ROLE_ADMIN' => 'Admin',
                'ROLE_USER' => 'User'
            ),
            'required' => true,
            'multiple'=> true,
            'choices_as_values' => false,
        ));

        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-primary btn-block')
        ));

    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_userbundle_user';
    }
}
