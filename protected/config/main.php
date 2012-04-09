<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
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

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'pwd',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('92.63.196.253', '::1'),
        ),
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
                '<controller:catalog>/<action:search|searchajax>/<search_opt>/<text>/<sgroup:\d+>' => '<controller>/<action>',
                '<controller:catalog>/<action:search|searchajax>/<search_opt>/<text>/<sgroup:\d+>/<gtype:\d+>' => '<controller>/<action>',
                '<controller:catalog>/<action:search|searchajax>/<search_opt>/<text>' => '<controller>/<action>',
                '<controller:catalog>/<action:meta>/<gid:\d+>/<sid:\d>' => '<controller>/<action>',
                '<controller:catalog>/<action:meta>/<gid>/<sid>/<gtype:\d+>' => '<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
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
            'username' => 'root',
            'tablePrefix' => 'fl_',
            'password' => 'vig2orv115',
            'charset' => 'utf8',
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
                ),
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('127.0.0.1', '178.49.9.5', '92.63.196.253'),
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
        'uploadServer' => '212.20.62.34:82',
        '212.20.62.34_skey' => 'bananaphone',
        '92.63.196.253_skey' => 'bananaphone',
        '92.63.196.74_skey' => 'bananaphone',
        'sendMail' => true,
        'imports' => true,
        'guestUploads' => true,
        'email_confirm' => true,
        'adminEmail' => 'support@fastlink.ws',
        'supportEmail' => 'support@fastlink.ws',
        'filePerPage' => 20,
//        'siteUrl' => 'http://fastlink2.anka.ws:81/',
    ),
);