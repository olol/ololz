<?php
return array(
    'asset_bundle' => array(
    	'cachePath' => '@zfRootPath/public/assets/cache',//cache directory absolute path
        'assets' => array(
            'css' => array('css'),
            'js' => array(
                'js/jquery.min.js',
                'js/bootstrap.min.js'
            ),
            'media' => array('images'),
            'less' => array('@zfRootPath/vendor/twitter/bootstrap/less/bootstrap.less')
        )
    ),
);