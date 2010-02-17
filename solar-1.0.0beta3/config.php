<?php
/**
 * all config values go in this array, which will be returned at the end of
 * this script. vendor configs should modify this array directly.
 */
$config = array();

/**
 * system directory
 */
$system = dirname(__FILE__);
$config['Solar']['system'] = $system;

/**
 * default configs for each vendor
 */
include "$system/source/solar/config/default.php";

/**
 * project overrides
 */

// front controller
$config['Solar_Controller_Front'] = array(
    'classes' => array('Hello_App', 'Solar_App'),
    'disable' => array(),
    'default' => 'default',
    'rewrite' => array(
      'solar-1.0.0beta3/index.php/hello/(\w+)' => 'hello/index/$1',
      'solar-1.0.0beta3/index.php/products' => 'hello/products',
//      'sflive2010/solar-1.0.0beta3/index.php/hello/(\w+)' => 'hello/index/$1',
//      'sflive2010/solar-1.0.0beta3/index.php/products' => 'hello/products',
    ),
    'routing' => array(),
    'explain' => true,
);

// model catalog
$config['Solar_Sql_Model_Catalog']['classes'] = array();

/**
 * done!
 */
return $config;
