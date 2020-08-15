<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TIC\PlatformBundle\Entity\AddressesRepository;
use TIC\PlatformBundle\Entity\Sessions;
use TIC\PlatformBundle\Entity\TrainersRepository;
use TIC\PlatformBundle\Entity\TrainingsRepository;

class SessionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Sessions $session */
        $session = $builder->getData();

        $builder->add('sessionDailyAmount', 'number', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'session.daily.amount',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('sessionNumberOfDays', 'number', array(
            'attr' => array('class' => 'form-control', 'min' => 0, 'step' => 0.01),
            'label' => 'contract.days.number',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('training', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'training',
            'class' => 'TIC\PlatformBundle\Entity\Trainings',
            'choice_label' => 'trainingName',
            'query_builder' => function (TrainingsRepository $tr) {
                return $tr->findAllActiveQuery();
            },
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
            'multiple' => false,
        ));

        $builder->add('language', 'entity', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.language',
            'class' => 'TIC\PlatformBundle\Entity\Languages',
            'choice_label' => 'language',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
        ));

        $builder->add('trainer', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'trainer',
            'class' => 'TIC\PlatformBundle\Entity\Trainers',
            'query_builder' => function(TrainersRepository $tr) {
                return $tr->findAllActiveQuery();
            },
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
            'multiple' => true,
        ));

        $builder->add('address', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'address',
            'class' => 'TIC\PlatformBundle\Entity\Addresses',
            'query_builder' => function (AddressesRepository $ar) use ($session) {
                return $ar->findByContractQuery($session->getContract());
            },
            //'choice_label' => 'addressLocality',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
        ));

        $builder->add('contract', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'contract',
            'class' => 'TIC\PlatformBundle\Entity\Contracts',
            'choice_label' => 'contractNumber',
            'label_attr' => array('class' => 'control-label col-md-3 '),
            'required' => true,
            'multiple' => false,

        ));

        $builder->add('RangeDate', new RangeDatesType());

        $builder->add('PerformanceType', 'entity', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'performance.type',
            'class' => 'TIC\PlatformBundle\Entity\PerformancesTypes',
            'choice_label' => 'PerformanceType',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
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
            'data_class' => 'TIC\PlatformBundle\Entity\Sessions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_sessions';
    }
}
