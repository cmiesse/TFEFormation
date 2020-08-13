<?php
/**
 * Created by PhpStorm.
 * Date: 24-05-16
 * Time: 09:54
 */
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\Countries;
use TIC\PlatformBundle\Form\CountryFormType;

class CountryController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:Countries";
        $this->indexTwig = "TICPlatformBundle:Country:view.html.twig";
        $this->editTwig = "TICPlatformBundle:Country:%s.html.twig";
        $this->indexRoute = "tic_platform_main_country_index";
        $this->screenName = "country";
        $this->emptyObject = new Countries();
        $this->formType = new CountryFormType(true);
    }
}