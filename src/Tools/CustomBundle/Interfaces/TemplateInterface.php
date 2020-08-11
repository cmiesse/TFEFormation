<?php
/**
 * Created by PhpStorm.
 * Date: 19-05-16
 */

namespace Tools\CustomBundle\Interfaces;

interface TemplateInterface
{
    public function __construct();

    public function validateNames();

    public function setRequiredNames();
}