<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TIC\PlatformBundle\Entity\ToolsRepository;

class TrainingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('trainingName','text', array(
            'attr' => array('class'=>'form-control'),
            'label'=> 'training.name',
            'label_attr' => array('class'=>'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('trainingActive', 'checkbox', array(
            'label' => 'active',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainingLink','text', array(
            'attr' => array('class'=>'form-control'),
            'label'=> 'training.link',
            'label_attr' => array('class'=>'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('tools', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'training.tools',
            'class' => 'TIC\PlatformBundle\Entity\Tools',
            'choice_label' => 'toolName',
            'query_builder' => function (ToolsRepository $tr) {
                return $tr->findAllFilteredQuery();
            },
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
            'multiple'=> true,
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
            'data_class' => 'TIC\PlatformBundle\Entity\Trainings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_trainings';
    }
}
