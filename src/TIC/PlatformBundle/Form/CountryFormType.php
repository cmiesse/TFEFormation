<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Tools\CustomBundle\Form\CustomSaveFormType;

class CountryFormType extends CustomSaveFormType
{
    /**
     * @var boolean
     */
    private $withSave;

    /**
     * IPMUserFormType constructor.
     * @param bool|false $withSave
     */
    public function __construct($withSave = false)
    {
        parent::__construct();
        
        $this->withSave = $withSave;
    }

    public function setRequiredNames()
    {
        $this->data_class = 'TIC\PlatformBundle\Entity\Countries';
        $this->name = 'country_form';
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->withSave) {
            parent::buildForm($builder, $options);
        }

        $builder->add('countryName', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'country.name',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));
    }
}