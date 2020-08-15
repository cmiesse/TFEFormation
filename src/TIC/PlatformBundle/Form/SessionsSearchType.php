<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SessionsSearchType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('training', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'training',
            'class' => 'TIC\PlatformBundle\Entity\Trainings',
            'choice_label' => 'trainingName',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false,
            'multiple' => true,
        ));
        $builder->add('trainer', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'trainer',
            'class' => 'TIC\PlatformBundle\Entity\Trainers',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false,
            'multiple' => true,
        ));
        $builder->add('RangeDate', new RangeDatesType(false));

        $builder->add('client', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'client',
            'class' => 'TIC\PlatformBundle\Entity\Clients',
            'choice_label' => 'clientName',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false,
            'multiple' => true,
        ));

        $builder->add('contract', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'contract',
            'class' => 'TIC\PlatformBundle\Entity\Contracts',
            'choice_label' => 'contractNumber',
            'label_attr' => array('class' => 'control-label col-md-3 '),
            'required' => false,
            'multiple'=> true,
        ));

        $builder->add('Search','submit', array(
            'attr' => array('class'=>'btn btn-success btn-block')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ticplatform_bundle_sessions_search_type';
    }
}
