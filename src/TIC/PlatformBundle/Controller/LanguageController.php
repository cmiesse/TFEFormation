<?php
/**
 * Created by PhpStorm.
 * Date: 24-05-16
 * Time: 09:54
 */
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\Languages;
use TIC\PlatformBundle\Form\LanguageFormType;

class LanguageController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:Languages";
        $this->indexTwig = "TICPlatformBundle:Language:view.html.twig";
        $this->editTwig = "TICPlatformBundle:Language:%s.html.twig";
        $this->indexRoute = "tic_platform_main_language_index";
        $this->screenName = "language";
        $this->emptyObject = new Languages();
        $this->formType = new LanguageFormType(true);
    }
}