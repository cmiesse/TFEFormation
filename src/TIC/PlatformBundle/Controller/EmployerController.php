<?php
/**
 * Created by PhpStorm.
 * Date: 24-05-16
 * Time: 09:54
 */
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\Employer;
use TIC\PlatformBundle\Form\EmployerFormType;

class EmployerController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:Employer";
        $this->indexTwig = "TICPlatformBundle:Employer:view.html.twig";
        $this->editTwig = "TICPlatformBundle:Employer:%s.html.twig";
        $this->indexRoute = "tic_platform_main_employer_index";
        $this->screenName = "employer";
        $this->emptyObject = new Employer();
        $this->formType = new EmployerFormType(true);
    }
}