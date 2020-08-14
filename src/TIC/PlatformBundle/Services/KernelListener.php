<?php
/**
 * Created by PhpStorm.
 * Date: 25-05-16
 * Time: 12:46
 */

namespace TIC\PlatformBundle\Services;


use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class KernelListener
{
    private $routes = array(
        'fos_user_security_login'
    );

    private $routesWithoutMaintenance = array(
        'fos_user_security_login',
        'fos_user_security_check',
        'fos_user_security_logout',
        'tic_platform_main_maintenance'
    );

    /**
     * @var AuthorizationChecker
     */
    private $security;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var bool
     */
    private $maintenance;

    public function __construct(AuthorizationChecker $security, Router $router, $maintenance)
    {
        $this->security = $security;
        $this->router = $router;
        $this->maintenance = $maintenance;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        if ($this->security->isGranted("IS_AUTHENTICATED_REMEMBERED") && in_array($route, $this->routes)) {
            $event->setResponse(new RedirectResponse($this->router->generate('tic_platform_main_dispatch')));
        }
        if ($this->maintenance) {
            if (!($this->security->isGranted("ROLE_SUPER_ADMIN") || $this->security->isGranted("ROLE_PREVIOUS_ADMIN"))) {
                if (!in_array($route, $this->routesWithoutMaintenance)) {
                    $event->setResponse(new RedirectResponse($this->router->generate('tic_platform_main_maintenance')));
                }
            }
        }
    }
}