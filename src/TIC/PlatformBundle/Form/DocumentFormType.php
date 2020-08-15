<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Tools\CustomBundle\Form\CustomSaveFormType;

class DocumentFormType extends CustomSaveFormType
{
    /**
     * @var boolean
     */
    private $withSave;

    /**
     * @var null|string
     */
    private $label;

    /**
     * @var bool
     */
    private $multiple;

    /**
     * IPMUserFormType constructor.
     * @param bool|false $withSave
     * @param string $label;
     * @param bool $multiple
     */
    public function __construct($withSave = false, $label = null, $multiple = false)
    {
        parent::__construct();
        
        $this->withSave = $withSave;
        $this->label = $label;
        $this->multiple = $multiple;
    }

    public function setRequiredNames()
    {
        $this->data_class = 'TIC\PlatformBundle\Entity\Document';
        $this->name = 'document_form';
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

        $builder->add('file', 'file', array(
            'label' => $this->label ? $this->label : 'file',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false,
            'multiple' => $this->multiple
        ));
    }
}