<?php
return array(
    'asset_bundle' => array(
    	'cachePath' => '@zfRootPath/public/assets/cache',//cache directory absolute path
        'assets' => array(
            'css' => array(
                'css/bootstrap.css',
                'css/style.css',
                'css/bootstrap-responsive.css',
            ),
            'js' => array(
                'js/jquery.min.js',
                'js/bootstrap.js'
            ),
            'media' => array('images'),
            'less' => array('@zfRootPath/vendor/twitter/bootstrap/less/bootstrap.less')
        )
    ),
);