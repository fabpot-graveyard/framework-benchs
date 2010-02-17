<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/hello/:name', array('controller' => 'pages', 'action' => 'hello'));
	Router::connect('/products', array('controller' => 'products', 'action' => 'products'));
	Router::connect('/product/:id', array('controller' => 'products', 'action' => 'product'));
	Router::connect('/route_1/:slug', array('controller' => 'products', 'action' => 'route_1'));
	Router::connect('/route_2/:slug', array('controller' => 'products', 'action' => 'route_2'));
	Router::connect('/route_3/:slug', array('controller' => 'products', 'action' => 'route_3'));
	Router::connect('/route_4/:slug', array('controller' => 'products', 'action' => 'route_4'));
	Router::connect('/route_5/:slug', array('controller' => 'products', 'action' => 'route_5'));
	Router::connect('/route_6/:slug', array('controller' => 'products', 'action' => 'route_6'));
	Router::connect('/route_7/:slug', array('controller' => 'products', 'action' => 'route_7'));
	Router::connect('/route_8/:slug', array('controller' => 'products', 'action' => 'route_8'));
	Router::connect('/route_9/:slug', array('controller' => 'products', 'action' => 'route_9'));
	Router::connect('/route_10/:slug', array('controller' => 'products', 'action' => 'route_10'));
	Router::connect('/route_11/:slug', array('controller' => 'products', 'action' => 'route_11'));
	Router::connect('/route_12/:slug', array('controller' => 'products', 'action' => 'route_12'));
	Router::connect('/route_13/:slug', array('controller' => 'products', 'action' => 'route_13'));
	Router::connect('/route_14/:slug', array('controller' => 'products', 'action' => 'route_14'));
	Router::connect('/route_15/:slug', array('controller' => 'products', 'action' => 'route_15'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
//	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
?>