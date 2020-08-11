<?php
/**
 * Created by PhpStorm.
 * Date: 19-05-16
 */

namespace Tools\CustomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tools\CustomBundle\Interfaces\TemplateInterface;

abstract class CustomFormType extends AbstractType implements TemplateInterface
{
    /**
     * @var string
     */
    protected $data_class;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $ignoreDataClass = false;

    /**
     * ParameterFormType constructor.
     */
    public function __construct()
    {
        $this->setRequiredNames();

        $this->validateNames();
    }

    public function validateNames()
    {
        if (!isset($this->data_class) && !$this->ignoreDataClass)
        {
            throw new \Exception('missing data_class');
        }

        if (!isset($this->name))
        {
            throw new \Exception('missing form_name');
        }
    }

    abstract function setRequiredNames();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultsOptions(OptionsResolver $resolver)
    {
        if ($this->data_class !== null) {
            $resolver->setDefaults(array(
                'data_class' => $this->data_class
            ));
        }
    }
}