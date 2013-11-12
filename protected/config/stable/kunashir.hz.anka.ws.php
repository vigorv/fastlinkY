<?php

$localconfig=
        array(
    	    'name' => 'FastLink',
    	     'components' =>
            array(
             'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                        'categories'=>'*',
                ),
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('5.128.106.6'),
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        )
       )
     );
?>
