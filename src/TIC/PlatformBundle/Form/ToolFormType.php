<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Tools\CustomBundle\Form\CustomSaveFormType;

class ToolFormType extends CustomSaveFormType
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
        $this->data_class = 'TIC\PlatformBundle\Entity\Tools';
        $this->name = 'tool_form';
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

        $builder->add('toolName', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'tool.name',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('editor', 'entity', array(
            'class' => 'TIC\PlatformBundle\Entity\Editor',
            'choice_label' => 'editorName',
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'editor',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));
    }
}