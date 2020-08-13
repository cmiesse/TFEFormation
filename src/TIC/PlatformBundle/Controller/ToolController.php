<?php
/**
 * Created by PhpStorm.
 * Date: 24-05-16
 * Time: 09:54
 */
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\Tools;
use TIC\PlatformBundle\Form\ToolFormType;

class ToolController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:Tools";
        $this->indexTwig = "TICPlatformBundle:Tools:view.html.twig";
        $this->editTwig = "TICPlatformBundle:Tools:%s.html.twig";
        $this->indexRoute = "tic_platform_main_tool_index";
        $this->screenName = "tool";
        $this->emptyObject = new Tools();
        $this->formType = new ToolFormType(true);
    }
}