<?php

namespace Tools\CustomBundle\Interfaces;

interface TemplateInterface
{
    public function __construct();

    public function validateNames();

    public function setRequiredNames();
}