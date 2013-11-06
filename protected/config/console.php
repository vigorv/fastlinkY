<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR .'..',
    'name' => 'FastLink',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
// uncomment the following to enable the Gii tool
        'admin' => array(
            'defaultController' => 'site',
            'import' => array(
                'admin.models.*',
                'admin.components.*',
            )
        ),
    ),
    // application components
    'components' => array(
        'clienscript' => array(
            'scriptMap' => array(
                'jquery' => '/js/jquery-1.7.2.js',
                'jquery.min' => '/js/jquery-1.7.2.min.js',
                'jquery.cookie' => '/js/jquery.cookie.js',
            ),
        ),
        'detectMobileBrowser' => array(
            'class' => 'ext.yii-detectmobilebrowser.XDetectMobileBrowser',
        ),
        'browser' => array(
            'class' => 'application.extensions.browser.CBrowserComponent',
        ),
        'search' => array(
            'class' => 'application.components.DGSphinxSearch',
            'server' => '127.0.0.1',
            'port' => 3312,
            'maxQueryTime' => 1000,
            'enableProfiling' => 1,
            'enableResultTrace' => 0,
            'fieldWeights' => array(
                'name' => 10000,
                'keywords' => 100,
            ),
        ),
        'user' => array(
// enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
        	'site/error404'=>'site/error404',
        	'site/error503'=>'site/error503',
                '<controller:catalog>/<action:search|searchajax>/<search_opt>/<text>/<sgroup:\d+>' => '<controller>/<action>',
                '<controller:catalog>/<action:search|searchajax>/<search_opt>/<text>/<sgroup:\d+>/<gtype:\d+>' => '<controller>/<action>',
                '<controller:catalog>/<action:search|searchajax>/<search_opt>/<text>' => '<controller>/<action>',
                '<controller:catalog>/<action:meta>/<gid:\d+>/<sid:\d>' => '<controller>/<action>',
                '<controller:catalog>/<action:meta>/<gid>/<sid>/<gtype:\d+>' => '<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>'=>'admin/<controller>/index',
                '<controller:pages>/<pagename:\w+>' => 'pages/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //'<controller:catalog>/<action:meta>'
                '<controller:\w+>/<action:\w+>/<id:\d+>/<int1:\d+>' => '<controller>/<action>',
            ),
            'showScriptName' => false,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=fastlink2',
            'emulatePrepare' => true,
            'username' => 'fldbusr',
            'tablePrefix' => 'fl_',
            'password' => 'akl,gfhjkm',
            'charset' => 'utf8',
        ),
        
        'dblog'=>array(
            'connectionString' => 'mysql:host=dhz1.anka.ws;dbname=wsmedia',
            'emulatePrepare'=>true,
            'username'=>'wsmedia',
            'tablePrefix'=>'fl_',
            'password'=>'6ND8vkHlNvwxUGPxfQIRz012',
            'charset'=>'utf8',
            'class'            => 'CDbConnection'            
        ),
        'errorHandler' => array(
// use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
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
                    'ipFilters' => array('127.0.0.1','178.49.9.12'),
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
// using Yii::app()->params['paramName']
    'sourceLanguage' => 'en',
    'Language' => 'ru',
    'params' => array(
// this is used in contact page
        'cloud_service_uri' => 'safelib.com',
        'cloud_service_partner_id_sg1' => 4,
        'cloud_service_partner_id_sg2' => 5,
        'uploadServer' => '212.20.62.34:83',
        'uploadServer_sg2' => '92.63.192.7:82',
 	'uploadServerA_sg2' => '92.63.196.3:82',
        '212.20.62.34_skey' => 'bananaphone',
        //'92.63.196.253_skey' => 'bananaphone',
        '178.49.9.12_skey'=>'bananaphone',
        '92.63.196.74_skey' => 'bananaphone',
        '92.63.192.7_skey'=>'bananaphone',
	'178.63.75.137_skey'=>'bananaphone',
	'92.63.196.2_skey'=>'bananaphone',
	'37.192.249.3_skey'=>'bananaphone',
	'92.63.196.3_skey'=>'bananaphone',
        'master_key'=>'lookingforgroup',
        'admin_items_per_page'=>30,
        'news_categories_sg2'=>'51,50,59,76,70,88,90,1,0',
        'sendMail' => true,
        'imports' => false,
        'guestUploads' => true,
        'email_confirm' => true,
        'adminEmail' => 'support@fastlink.ws',
        'supportEmail' => 'support@fastlink.ws',
        'filePerPage' => 20,
//        'siteUrl' => 'http://fastlink.ws/',
    ),
);
