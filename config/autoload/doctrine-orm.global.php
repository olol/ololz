<?php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'ololz',
                )
            )
        ),

        'configuration' => array(
            'orm_default' => array(
                'metadata_cache'     => 'array',

//                'driver'             => 'orm_default',

                'generate_proxies'   => true,
                'proxy_dir'          => 'data/cache/entity/proxy',
                'proxy_namespace'    => 'Ololz\Entity\Proxy',

//                'filters'            => array()  // array('filterName' => 'BSON\Filter\Class')
            )
        ),

        'driver' => array(
            'ololz' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../../module/Ololz/src/Ololz/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Ololz\Entity'  => 'ololz'
                )
            )
        ),

        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\Sluggable\SluggableListener',
                    'Gedmo\Timestampable\TimestampableListener',
                )
            )
        ),
    ),
);