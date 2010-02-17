<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\net\http\Router;

/**
 * Uncomment the line below to enable routing for admin actions.
 * @todo Implement me.
 */
// Router::namespace('/admin', array('admin' => true));

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'view', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.html.php)...
 */
Router::connect('/hello/{:name}', array('controller' => 'hello_world', 'action' => 'index'));
Router::connect('/products', array('controller' => 'products', 'action' => 'products'));
Router::connect('/product/{:id}', array('controller' => 'products', 'action' => 'product'));
Router::connect('/route_1/{:slug}', array('controller' => 'products', 'action' => 'route_1'));
Router::connect('/route_2/{:slug}', array('controller' => 'products', 'action' => 'route_2'));
Router::connect('/route_3/{:slug}', array('controller' => 'products', 'action' => 'route_3'));
Router::connect('/route_4/{:slug}', array('controller' => 'products', 'action' => 'route_4'));
Router::connect('/route_5/{:slug}', array('controller' => 'products', 'action' => 'route_5'));
Router::connect('/route_6/{:slug}', array('controller' => 'products', 'action' => 'route_6'));
Router::connect('/route_7/{:slug}', array('controller' => 'products', 'action' => 'route_7'));
Router::connect('/route_8/{:slug}', array('controller' => 'products', 'action' => 'route_8'));
Router::connect('/route_9/{:slug}', array('controller' => 'products', 'action' => 'route_9'));
Router::connect('/route_10/{:slug}', array('controller' => 'products', 'action' => 'route_10'));
Router::connect('/route_11/{:slug}', array('controller' => 'products', 'action' => 'route_11'));
Router::connect('/route_12/{:slug}', array('controller' => 'products', 'action' => 'route_12'));
Router::connect('/route_13/{:slug}', array('controller' => 'products', 'action' => 'route_13'));
Router::connect('/route_14/{:slug}', array('controller' => 'products', 'action' => 'route_14'));
Router::connect('/route_15/{:slug}', array('controller' => 'products', 'action' => 'route_15'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/pages/{:args}', array('controller' => 'pages', 'action' => 'view'));

/**
 * Connect the testing routes.
 */
Router::connect('/test/{:args}', array('controller' => '\lithium\test\Controller'));
Router::connect('/test', array('controller' => '\lithium\test\Controller'));

/**
 * Finally, connect the default routes.
 */
Router::connect('/{:controller}/{:action}/{:id:[0-9]+}.{:type}', array('id' => null));
Router::connect('/{:controller}/{:action}/{:id:[0-9]+}');
Router::connect('/{:controller}/{:action}/{:args}');

?>