<?php

/*
 * This file is part of the JMSSerializerModule package.
 *
 * (c) Martin Parsiegla <martin.parsiegla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
    'jms_serializer' => array(
        'property_naming' => array(
            'enable_cache' => true
        ),
        'metadata' => array(
            'cache' => 'file',
            'annotation_cache' => 'array',
            'debug' => false,
            'file_cache' => array(
                'dir' => 'data/cache/JMSSerializerModule',
            ),
            'infer_types_from_doctrine_metadata' => true,
        ),
    ),
);
