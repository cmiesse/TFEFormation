<?php
namespace TIC\PlatformBundle\Controller;

use Tools\CustomBundle\Controller\MasterController;

class MaintenanceController extends MasterController
{
    public function indexAction()
    {
        return $this->render('TICPlatformBundle:Maintenance:index.html.twig');
    }
}