<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactPeopleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contactPersonLastname', 'text', array(
                'attr' => array('class' => 'form-control'),
                'label' => 'contactPerson.lastname',
                'label_attr' => array('class' => 'control-label col-md-3'),
                'required' => true
        ));

        $builder->add('contactPersonFirstname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contactPerson.firstname',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contactPersonPhone', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contactPerson.phone',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contactPersonmail', 'email', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contactPerson.mail',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contactPersonFunction', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contactPerson.function',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('contactPersonLanguage', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contactPerson.language',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contactPersonGender', 'choice', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contactPerson.gender',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'choices' => array(
                'F' =>'Woman',
                'M' => 'Man',
            ),
            'required' => true
        ));

        $builder->add('address', new AddressesType());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\ContactPeople'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_contactpeople';
    }
}
