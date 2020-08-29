<?php

namespace Tools\CustomBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

abstract class CustomSaveFormType extends CustomFormType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('save', 'submit', array(
            'label' => 'save',
            'attr' => array('class' => 'btn btn-primary btn-block')
        ));
    }
}