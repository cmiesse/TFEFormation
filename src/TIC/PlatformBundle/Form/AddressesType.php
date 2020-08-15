<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('addressLine1', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'address.line.1',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('addressLine2', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'address.line.2',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('addressZipCode', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'address.zip.code',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('addressLocality', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'address.locality',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('countries', 'entity', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'address.country',
            'class' => 'TIC\PlatformBundle\Entity\Countries',
            'choice_label' => 'countryName',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\Addresses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_addresses';
    }
}
