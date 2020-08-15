<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RangeDatesType extends AbstractType
{
    /**
     * @var bool
     */
    private $required;

    public function __construct($required = true)
    {
        $this->required = $required;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rangeDateBegin', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'years'=> range(date('Y')-1, date('Y')+10),
            'label' => 'range.date.begin',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => $this->required,
        ));

        $builder->add('rangeDateEnd', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'years'=> range(date('Y')-1, date('Y')+10),
            'label' => 'range.date.end',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => $this->required,
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\RangeDates'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_rangedates';
    }
}
