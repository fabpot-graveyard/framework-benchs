<?php
declare(ENCODING = 'utf-8');
namespace F3\Testing;

/*                                                                        *
 * This script belongs to the FLOW3 package "Testing".                    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License as published by the Free   *
 * Software Foundation, either version 3 of the License, or (at your      *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with the script.                                                 *
 * If not, see http://www.gnu.org/licenses/gpl.html                       *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/*
 * PHPUnit offers the possibility to use a "bootstrap" file with every test.
 * This file can be used and will register a simple autoloader so that the files
 * used in the tests can be found.
 *
 * To use PHPUnit with Netbeans create a folder to be used as project test folder
 * and populate it with something like
 *  for i in `ls ../Packages/Framework/` ;
 *    do ln -s ../Packages/Framework/$i/Tests/Unit $i ;
 *  done
 */

/**
 * A simple class loader that deals with the Framework classes and is intended
 * for use with PHPUnit.
 *
 * @param string $className
 * @return void
 * @author Karsten Dambekalns <karsten@typo3.org>
 */
function loadClassForTesting($className) {
	$classNameParts = explode('\\', $className);
	if (is_array($classNameParts) && $classNameParts[0] === 'F3') {
		$classFilePathAndName = dirname(__FILE__) . '/../../' . $classNameParts[1] . '/Classes/';
		$classFilePathAndName .= implode(array_slice($classNameParts, 2, -1), '/') . '/';
		$classFilePathAndName .= end($classNameParts) . '.php';
	}
	if (isset($classFilePathAndName) && file_exists($classFilePathAndName)) require($classFilePathAndName);
}

spl_autoload_register('F3\Testing\loadClassForTesting');
set_include_path(get_include_path() . ':' . dirname(__FILE__) . '/../../PHPUnit/Resources/PHP');

if (!defined('FLOW3_PATH_FLOW3')) {
	define('FLOW3_PATH_FLOW3', str_replace('//', '/', str_replace('\\', '/', (realpath(__DIR__ . '/../../FLOW3/') . '/'))));
}
?>
