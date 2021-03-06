<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\MVC\Web\Routing;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
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

/**
 * Contract for a Web Router
 *
 * @version $Id: RouterInterface.php 2813 2009-07-16 14:02:34Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface RouterInterface {

	/**
	 * Walks through all configured routes and calls their respective matches-method.
	 * When a corresponding route is found, package, controller, action and possible parameters
	 * are set on the $request object
	 *
	 * @param \F3\FLOW3\MVC\Web\Request $request
	 * @return boolean
	 */
	public function route(\F3\FLOW3\MVC\Web\Request $request);

	/**
	 * Walks through all configured routes and calls their respective resolves-method.
	 * When a matching route is found, the corresponding URI is returned.
	 *
	 * @param array $routeValues
	 * @return string URI
	 */
	public function resolve(array $routeValues);
}
?>