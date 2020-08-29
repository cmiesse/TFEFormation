<?php
namespace TIC\PlatformBundle\Controller;

use Tools\CustomBundle\Controller\MasterController;

class MainController extends MasterController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function dispachAction()
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('tic_platform_main_webmaster');
        }
        return $this->redirectToRoute('tic_platform_clients');
    }
}