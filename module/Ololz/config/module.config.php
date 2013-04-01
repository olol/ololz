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
                'js/highcharts.js' => array(
                    'assets/highcharts/highcharts.src.js'
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
                            'route' => 'summoner/:summoner',
                            'constraints' => array(
                                'summoner' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'summoner',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'champion' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/champion/:champion',
                                    'constraints' => array(
                                        'champion' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                    ),
                                    'defaults' => array(
                                        'action' => 'champion',
                                    ),
                                ),
                            ),
                            'invocations' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/invocations',
                                    'defaults' => array(
                                        'action' => 'invocations',
                                    ),
                                ),
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
                            'route' => 'match/:match',
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
                            'route' => 'champion/:champion',
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
                            'route' => 'item/:item',
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
            'layout/layout'     => __DIR__ . '/../view/layout/layout.phtml',
            'ololz/index/index' => __DIR__ . '/../view/ololz/index/index.phtml',
            'error/404'         => __DIR__ . '/../view/error/404.phtml',
            'error/index'       => __DIR__ . '/../view/error/index.phtml',

            // Partials
            'ololz/p/summoner/champion'             => __DIR__ . '/../view/ololz/summoner/partials/champion.phtml',
            'ololz/p/summoner/invocation'           => __DIR__ . '/../view/ololz/summoner/partials/invocation.phtml',
            'ololz/p/match/invocation'              => __DIR__ . '/../view/ololz/match/partials/invocation.phtml',
            'ololz/p/champion/line'                 => __DIR__ . '/../view/ololz/champion/partials/line.phtml',
            'ololz/p/champion/picture-icon'         => __DIR__ . '/../view/ololz/champion/partials/picture-icon.phtml',
            'ololz/p/champion/picture-small'        => __DIR__ . '/../view/ololz/champion/partials/picture-small.phtml',
            'ololz/p/champion/picture-normal'       => __DIR__ . '/../view/ololz/champion/partials/picture-normal.phtml',
            'ololz/p/item/line'                     => __DIR__ . '/../view/ololz/item/partials/line.phtml',
            'ololz/p/item/picture-icon'             => __DIR__ . '/../view/ololz/item/partials/picture-icon.phtml',
            'ololz/p/item/picture-small'            => __DIR__ . '/../view/ololz/item/partials/picture-small.phtml',
            'ololz/p/spell/picture-icon'            => __DIR__ . '/../view/ololz/spell/partials/picture-icon.phtml',
            'ololz/p/spell/picture-small'           => __DIR__ . '/../view/ololz/spell/partials/picture-small.phtml',
            'ololz/p/invocation/line'               => __DIR__ . '/../view/ololz/invocation/partials/line.phtml',
            'ololz/p/invocation/detail/champion'    => __DIR__ . '/../view/ololz/invocation/partials/detail/champion.phtml',
            'ololz/p/invocation/detail/gold'        => __DIR__ . '/../view/ololz/invocation/partials/detail/gold.phtml',
            'ololz/p/invocation/detail/items'       => __DIR__ . '/../view/ololz/invocation/partials/detail/items.phtml',
            'ololz/p/invocation/detail/kda'         => __DIR__ . '/../view/ololz/invocation/partials/detail/kda.phtml',
            'ololz/p/invocation/detail/length'      => __DIR__ . '/../view/ololz/invocation/partials/detail/length.phtml',
            'ololz/p/invocation/detail/minions'     => __DIR__ . '/../view/ololz/invocation/partials/detail/minions.phtml',
            'ololz/p/invocation/detail/result'      => __DIR__ . '/../view/ololz/invocation/partials/detail/result.phtml',
            'ololz/p/invocation/detail/spells'      => __DIR__ . '/../view/ololz/invocation/partials/detail/spells.phtml',
            'ololz/p/invocation/detail/summoner'    => __DIR__ . '/../view/ololz/invocation/partials/detail/summoner.phtml',
            'ololz/p/invocation/detail/summoner'    => __DIR__ . '/../view/ololz/invocation/partials/detail/summoner.phtml',
            'ololz/p/match/line'                    => __DIR__ . '/../view/ololz/match/partials/line.phtml',
            'ololz/p/match/detail/summary'          => __DIR__ . '/../view/ololz/match/partials/detail/summary.phtml',
            'ololz/p/match/search'                  => __DIR__ . '/../view/ololz/match/partials/search.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
