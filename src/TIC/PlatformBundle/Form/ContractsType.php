<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contractNumber', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contract.number',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractTotalAmount', 'number', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contract.total.amount',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractDailyAmount', 'number', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contract.daily.amount',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractDaysNumber', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contract.days.number',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractBalance', 'number', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'contract.balance',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractBeginDate', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'label' => 'contract.begin.date',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractEndDate', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'label' => 'contract.end.date',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('contractExtendedEndDate', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'label' => 'contract.extended.date',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('facturationMode', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'class' => 'TIC\PlatformBundle\Entity\FacturationMode',
            'choice_label' => 'facturationModeLabel',
            'label' => 'facturation.mode',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('save','submit', array(
            'attr' => array('class'=>'btn btn-primary btn-block')
        ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\Contracts'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_contracts';
    }
}
