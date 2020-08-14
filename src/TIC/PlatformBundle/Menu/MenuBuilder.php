<?php

namespace TIC\PlatformBundle\Menu;

use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder extends ContainerAware
{
    /**
     * @var bool
     */
    private $routeFound = false;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $currentClass;

    /**
     * @var \Knp\Menu\MenuFactory
     */
    private $factory;

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    private $security;

    /**
     * @var array
     */
    private $currentParams;

    private $data;

    private function buildMenuDataAdmin()
    {
        $this->data = array(
            'Users' => array(
                'route' => 'tic_platform_main_webmaster',
                'label' => 'Users',
                'icon' => 'clip-users',
                'extras' => true
            ),
            'Calendar' => array(
                'route' => 'tic_platform_main_webmaster_calendar_list',
                'label' => 'Calendar',
                'icon' => 'clip-calendar',
                'extras' => true
            )
        );
    }

    private function buildMenuData()
    {
        $this->data = array(
            'Session' => array(
                'route' => 'tic_platform_sessions',
                'label' => 'Sessions',
                'icon' => 'clip-note',
                'extras' => true,
                'sub_routes' => array(
                    'tic_platform_sessions_edit',
                    'tic_platform_sessions_add',
                    'tic_platform_sessions_edit_planning'
                ),
                'additional_routes' => array(
                    'tic_platform_sessions_edit' => array(
                        'name' => 'Details',
                        'label' => 'Details',
                        'routeParameters' => array(
                            'id' => 'id'
                        )
                    ),
                    'tic_platform_sessions_edit_planning' => array(
                        'name' => 'Planning',
                        'label' => 'Planning',
                        'routeParameters' => array(
                            'id' => 'id'
                        )
                    )
                ),
                'children_attributes' => array(
                    'class' => 'sub-menu'
                )
            ),
            'Training' => array(
                'route' => 'tic_platform_trainings',
                'label' => 'Trainings',
                'icon' => 'clip-stack-empty',
                'extras' => true,
                'sub_routes' => array(
                    'tic_platform_trainings_add',
                    'tic_platform_trainings_edit'
                )
            ),
            'Planning' => array(
                'route' => 'tic_platform_planning',
                'label' => 'Planning',
                'icon' => 'clip-calendar',
                'extras' => true
            ),
            'Client' => array(
                'route' => 'tic_platform_clients',
                'label' => 'Clients',
                'icon' => 'clip-user-5',
                'extras' => true,
                'sub_routes' => array(
                    'tic_platform_clients_edit',
                    'tic_platform_clients_add',
                    'tic_platform_contracts',
                    'tic_platform_contracts_add',
                    'tic_platform_contracts_edit'
                ),
                'additional_routes' => array(
                    'tic_platform_clients_edit' => array(
                        'name' => 'Details',
                        'label' => 'Details',
                        'routeParameters' => array(
                            'id' => 'id'
                        ),
                        'sub_routes' => array(
                        )
                    ),
                    'tic_platform_contracts' => array(
                        'name' => 'Contract',
                        'label' => 'Contracts',
                        'routeParameters' => array(
                            'id' => 'id'
                        ),
                        'sub_routes' => array(
                            'tic_platform_contracts_add',
                            'tic_platform_contracts_edit'
                        )
                    )
                ),
                'children_attributes' => array(
                    'class' => 'sub-menu'
                )
            ),
            'Trainer' => array(
                'route' => 'tic_platform_trainers',
                'label' => 'Trainers',
                'icon' => 'clip-star-3',
                'extras' => true,
                'sub_routes' => array(
                    'tic_platform_trainers_edit',
                    'tic_platform_trainers_add'
                )
            ),
            'Users' => array(
                'route' => 'tic_platform_users',
                'label' => 'Users',
                'icon' => 'clip-users',
                'extras' => true,
                'sub_routes' => array(
                    'tic_platform_users_edit',
                    'tic_platform_users_add'
                ),
                'roles' => array(
                    'ROLE_ADMIN'
                )
            ),
            'Parameters' => array(
                'label' => 'Parameters',
                'icon' => 'clip-settings',
                'extras' => true,
                'children' => array(
                    'Tools' => array(
                        'route' => 'tic_platform_main_tool_index',
                        'label' => 'Tools',
                        'sub_routes' => array(
                            'tic_platform_main_tool_edit'
                        )
                    ),
                    'Editors' => array(
                        'route' => 'tic_platform_main_editor_index',
                        'label' => 'Editors',
                        'sub_routes' => array(
                            'tic_platform_main_editor_edit'
                        )
                    ),
                    'Languages' => array(
                        'route' => 'tic_platform_main_language_index',
                        'label' => 'Languages',
                        'sub_routes' => array(
                            'tic_platform_main_language_edit'
                        )
                    ),
                    'Countries' => array(
                        'route' => 'tic_platform_main_country_index',
                        'label' => 'Countries',
                        'sub_routes' => array(
                            'tic_platform_main_country_edit'
                        )
                    ),
                    'Employers' => array(
                        'route' => 'tic_platform_main_employer_index',
                        'label' => 'Employers',
                        'sub_routes' => array(
                            'tic_platform_main_employer_edit'
                        )
                    ),
                    'ClientsCategories' => array(
                        'route' => 'tic_platform_main_client_category_index',
                        'label' => 'Categories',
                        'sub_routes' => array(
                            'tic_platform_main_client_category_edit'
                        )
                    ),
                    'FacturationModes' => array(
                        'route' => 'tic_platform_main_facturation_mode_index',
                        'label' => 'Facturation Modes',
                        'sub_routes' => array(
                            'tic_platform_main_facturation_mode_edit'
                        )
                    ),
                    'PerformancesTypes' => array(
                        'route' => 'tic_platform_main_performance_type_index',
                        'label' => 'Performances Types',
                        'sub_routes' => array(
                            'tic_platform_main_performance_type_edit'
                        )
                    ),
                ),
                'children_attributes' => array(
                    'class' => 'sub-menu'
                )
            )
        );
    }

    public function __construct(Container $container)
    {
        $this->factory = $container->get('knp_menu.factory');
        $this->currentClass = $container->getParameter('knp_menu.renderer.twig.options')['currentClass'];
        $this->security = $container->get('security.authorization_checker');
    }

    public function createSidebarMenu(RequestStack $requestStack)
    {
        $this->route = $requestStack->getCurrentRequest()->attributes->get('_route');
        $this->currentParams = $requestStack->getCurrentRequest()->attributes->get('_route_params');
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'main-navigation-menu');
        $menu->setChildrenAttribute('id', 'side-menu');
        if ($this->security->isGranted("ROLE_SUPER_ADMIN")) {
            $this->buildMenuDataAdmin();
        } else {
            $this->buildMenuData();
        }
        $this->buildMenu($menu, $this->data);
        return $menu;
    }

    /**
     * @param MenuItem $menu
     * @param $data
     */
    private function buildMenu(MenuItem $menu, $data)
    {
        foreach ($data as $menuName => $info) {
            if (array_key_exists('roles', $info)) {
                if (!$this->security->isGranted($info['roles'])) {
                    continue;
                }
            }
            $opts = array();
            if (array_key_exists('route', $info)) {
                $opts['route'] = $info['route'];
                if (!$this->routeFound && strcmp($this->route, $info['route']) == 0) {
                    $this->routeFound = true;
                }
            } else {
                $opts['uri'] = 'javascript:void(0)';
            }
            $menu->addChild($menuName, $this->generateOptions($info, $opts));
            if (array_key_exists('children', $info)) {
                $subMenu = $menu[$menuName];
                if (array_key_exists('children_attributes', $info)) {
                    $subMenu->setChildrenAttributes($info['children_attributes']);
                }
                $this->buildMenu($subMenu, $info['children']);
            }
            if (!$this->routeFound && array_key_exists('sub_routes', $info) && in_array($this->route, $info['sub_routes'])) {
                $this->routeFound = true;
                $lastMenu = $menu[$menuName];
                if (array_key_exists('additional_routes', $info)) {
                    $lastMenu->setChildrenAttributes($info['children_attributes']);
                    foreach ($info['additional_routes'] as $route_name => $data) {
                        $opts_additional = array('route' => $route_name, 'routeParameters' => $this->paramToArray($data['routeParameters']));
                        if (count($opts_additional['routeParameters']) == 0) {
                            continue;
                        }
                        $lastMenu->addChild($data['name'], $this->generateOptions($data, $opts_additional));
                        if (array_key_exists('sub_routes', $data) && in_array($this->route, $data['sub_routes'])) {
                            $lastMenu[$data['name']]->setAttribute('class', $this->currentClass);
                        }
                    }
                }
                while (!is_null($lastMenu->getParent())) {
                    $lastMenu->setAttribute('class', $this->currentClass);
                    $lastMenu = $lastMenu->getParent();
                }
            }
        }
    }

    /**
     * @param array $data The array with the data to analyse
     * @param array $result The array with the options for the current item
     *
     * @return array
     */
    private function generateOptions(array $data, array $result)
    {
        $label = $data['label'];
        if (array_key_exists('icon', $data)) {
            $label = sprintf(
                '<i class="%s"></i><span class="title"> %s</span>%s<span class="selected"></span>',
                $data['icon'], $label, array_key_exists('children', $data) ? '<i class="icon-arrow"></i>' : null
            );
        }
        $result['label'] = $label;
        if (array_key_exists('extras', $data)) {
            $result['extras'] = array('safe_label' => true);
        }
        return $result;
    }

    /**
     * @param array $param
     * @return array
     */
    private function paramToArray(array $param)
    {
        $routeParameters = array();
        foreach ($param as $initName => $resultName) {
            if (array_key_exists($initName, $this->currentParams)) {
                $routeParameters[$resultName] = $this->currentParams[$initName];
            }
        }
        return $routeParameters;
    }
}