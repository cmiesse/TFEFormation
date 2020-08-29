<?php
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\FacturationMode;
use TIC\PlatformBundle\Form\FacturationModeFormType;

class FacturationModeController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:FacturationMode";
        $this->indexTwig = "TICPlatformBundle:FacturationMode:view.html.twig";
        $this->editTwig = "TICPlatformBundle:FacturationMode:%s.html.twig";
        $this->indexRoute = "tic_platform_main_facturation_mode_index";
        $this->screenName = "facturation.mode";
        $this->emptyObject = new FacturationMode();
        $this->formType = new FacturationModeFormType(true);
    }
}