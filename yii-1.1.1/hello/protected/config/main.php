<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array(),//array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(
	  'urlManager'=>array(
        'urlFormat'=>'path',
        'rules'=>array(
            'hello/<name:.*?>'=>'site/index',
            'products'=>'site/products',
            'product/<id:\d+>'=>'site/product',

            'route_1/<slug:\w+>'=>'site/route_1',
            'route_2/<slug:\w+>'=>'site/route_2',
            'route_3/<slug:\w+>'=>'site/route_3',
            'route_4/<slug:\w+>'=>'site/route_4',
            'route_5/<slug:\w+>'=>'site/route_5',
            'route_6/<slug:\w+>'=>'site/route_6',
            'route_7/<slug:\w+>'=>'site/route_7',
            'route_8/<slug:\w+>'=>'site/route_8',
            'route_9/<slug:\w+>'=>'site/route_9',
            'route_10/<slug:\w+>'=>'site/route_10',
            'route_11/<slug:\w+>'=>'site/route_11',
            'route_12/<slug:\w+>'=>'site/route_12',
            'route_13/<slug:\w+>'=>'site/route_13',
            'route_14/<slug:\w+>'=>'site/route_14',
            'route_15/<slug:\w+>'=>'site/route_15',

        ),
    ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
		),
		'db'=>array(
			'connectionString' => 'sqlite:protected/data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
/*
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
    */
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);