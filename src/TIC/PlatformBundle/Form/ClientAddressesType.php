<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientAddressesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('clientAddressLastname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'clientAddress.lastname',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('clientAddressFirstname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'clientAddress.firstname',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('clientAddressPhone', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'clientAddress.phone',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('clientAddressDelivery', 'checkbox', array(
            //'attr' => array('class' => 'form-control'),
            'label' => 'clientAddress.delivery',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('address', new AddressesType());
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\ClientAddresses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_clientaddresses';
    }
}
