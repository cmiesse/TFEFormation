<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    private $new;

    public function __construct($new = true)
    {
        $this->new = $new;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('clientName', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'client.name',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('clientAbbreviation', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'client.abbreviation',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('clientTVANumber', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'client.VATNumber',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('clientCategory', 'entity', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'client.category',
            'class' => 'TIC\PlatformBundle\Entity\ClientsCategories',
            'choice_label' => 'clientCategoryLabel',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        if($this->new)
        {
            $builder->add('singleAddress', new ClientAddressesType(), array(
                'data_class' => 'TIC\PlatformBundle\Entity\ClientAddresses'
            ));

            $builder->add('singleContactPerson', new ContactPeopleType(), array(
                'data_class' => 'TIC\PlatformBundle\Entity\ContactPeople'
            ));
        }

        $builder->add('save','submit', array(
            'attr' => array('class'=>'btn btn-primary btn-block'),
            'label' => 'client.save',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\Clients'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_clients';
    }
}
