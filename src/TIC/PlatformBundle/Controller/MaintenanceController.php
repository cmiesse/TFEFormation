<?php
/**
 * Created by PhpStorm.
 * Date: 17-08-16
 * Time: 11:38
 */

namespace TIC\PlatformBundle\Controller;

use Tools\CustomBundle\Controller\MasterController;

class MaintenanceController extends MasterController
{
    public function indexAction()
    {
        return $this->render('TICPlatformBundle:Maintenance:index.html.twig');
    }
}