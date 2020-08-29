<?php
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\PerformancesTypes;
use TIC\PlatformBundle\Form\PerformanceTypeFormType;

class PerformanceTypeController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:PerformancesTypes";
        $this->indexTwig = "TICPlatformBundle:PerformanceType:view.html.twig";
        $this->editTwig = "TICPlatformBundle:PerformanceType:%s.html.twig";
        $this->indexRoute = "tic_platform_main_performance_type_index";
        $this->screenName = "performance.type";
        $this->emptyObject = new PerformancesTypes();
        $this->formType = new PerformanceTypeFormType(true);
    }
}