<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/ololz.css' => array(
                    'assets/bootstrap/bootstrap.css',
                    'assets/ololz/ololz.css',
                    'assets/bootstrap/bootstrap-responsive.css',
                ),
                'js/ololz.js' => array(
                    'assets/jquery/jquery.js',
                    'assets/bootstrap/bootstrap.js',
                    'assets/ololz/ololz.js'
                ),
            ),
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
        'caching' => array(
            'default' => array(
                'cache'     => 'FilePath',
                'options' => array(
                    'dir' => __DIR__ . '/../../../data/cache/assets', // path/to/cache
                ),
            ),
        ),
        'filters' => array(
            'application/javascript' => array(
                array(
                    'filter' => 'JSMinPlus',  // Allowed format is Filtername[Filter]. Can also be FQCN
                ),
            ),
//            'text/css' => array(
//                array(
//                    'filter' => 'CssMin',  // Allowed format is Filtername[Filter]. Can also be FQCN
//                ),
//            ),
        ),
    ),

    'router' => array(
        'routes' => array(
            'ololz' => array(
                'priority' => 0,
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Ololz\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Ololz\Controller',
                                'action' => 'index',
                            ),
                        ),
                    ),

                    'summoner' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'summoner[/:summoner]',
                            'constraints' => array(
                                'summoner' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'summoner',
                                'action'     => 'index',
                            ),
                        ),
                    ),

                    'summoners' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'summoners[/page/:page]',
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'page'       => 1,
                                'controller' => 'summoner',
                                'action'     => 'list',
                            ),
                        ),
                    ),

                    'match' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'match[/:match]',
                            'constraints' => array(
                                'match' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'match',
                                'action'     => 'index',
                            ),
                        ),
                    ),

                    'matches' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'matches[/page/:page]',
                            'constraints' => array(
                                'page'      => '[0-9]+',
                            ),
                            'defaults' => array(
                                'page'       => 1,
                                'controller' => 'match',
                                'action'     => 'list',
                            ),
                        ),
                    ),

                    'champion' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'champion[/:champion]',
                            'constraints' => array(
                                'champion' => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'controller' => 'champion',
                                'action'     => 'index',
                            ),
                        ),
                    ),

                    'champions' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'champions[/page/:page]',
                            'constraints' => array(
                                'page'      => '[0-9]+',
                            ),
                            'defaults' => array(
                                'page'       => 1,
                                'controller' => 'champion',
                                'action'     => 'list',
                            ),
                        ),
                    ),

                    'item' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'item[/:item]',
                            'constraints' => array(
                                'item' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'item',
                                'action'     => 'index',
                            ),
                        ),
                    ),

                    'items' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'items[/page/:page]',
                            'constraints' => array(
                                'page'      => '[0-9]+',
                            ),
                            'defaults' => array(
                                'page'       => 1,
                                'controller' => 'item',
                                'action'     => 'list',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Ololz\Controller\Index'    => 'Ololz\Controller\IndexController',
            'Ololz\Controller\Updater'  => 'Ololz\Controller\UpdaterController',
            'Ololz\Controller\Champion' => 'Ololz\Controller\ChampionController',
            'Ololz\Controller\Match'    => 'Ololz\Controller\MatchController',
            'Ololz\Controller\Item'     => 'Ololz\Controller\ItemController',
            'Ololz\Controller\Summoner' => 'Ololz\Controller\SummonerController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
