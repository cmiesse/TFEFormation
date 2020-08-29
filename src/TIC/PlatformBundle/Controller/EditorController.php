<?php
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\Editor;
use TIC\PlatformBundle\Form\EditorFormType;

class EditorController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:Editor";
        $this->indexTwig = "TICPlatformBundle:Editor:view.html.twig";
        $this->editTwig = "TICPlatformBundle:Editor:%s.html.twig";
        $this->indexRoute = "tic_platform_main_editor_index";
        $this->screenName = "editor";
        $this->emptyObject = new Editor();
        $this->formType = new EditorFormType(true);
    }
}