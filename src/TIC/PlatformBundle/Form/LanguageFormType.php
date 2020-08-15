<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Tools\CustomBundle\Form\CustomSaveFormType;

class LanguageFormType extends CustomSaveFormType
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
        $this->data_class = 'TIC\PlatformBundle\Entity\Languages';
        $this->name = 'language_form';
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

        $builder->add('language', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'language',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));
    }
}