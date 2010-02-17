<?php
declare(ENCODING = 'utf-8');
namespace F3\YAML;

/*                                                                        *
 * This script belongs to the FLOW3 package "YAML".                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

require(__DIR__ . '/../Resources/Private/PHP/Horde/Yaml.php');
require(__DIR__ . '/../Resources/Private/PHP/Horde/Yaml/Loader.php');
require(__DIR__ . '/../Resources/Private/PHP/Horde/Yaml/Exception.php');
require(__DIR__ . '/../Resources/Private/PHP/Horde/Yaml/Node.php');
require(__DIR__ . '/../Resources/Private/PHP/Horde/Yaml/Dumper.php');

/**
 * Façade for a Yaml Parser and Dumper
 *
 * @version $Id: Yaml.php 3644 2010-01-15 14:49:53Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class Yaml extends \Horde_Yaml {

}

?>