<?php
declare(ENCODING = 'utf-8');
namespace F3\DocumentationBrowser\RoutePartHandlers;

/*                                                                        *
 * This script belongs to the FLOW3 package "DocumentationBrowser".       *
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

/**
 * File route part handler
 *
 * @version $Id: FileRoutePartHandler.php 2814 2009-07-16 14:04:39Z k-fish $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 */
class FileRoutePartHandler extends \F3\FLOW3\MVC\Web\Routing\DynamicRoutePart {

	/**
	 * Returns the value unaltered
	 *
	 * @param string $value value to match
	 * @return boolean TRUE
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function findValueToMatch($value) {
		return $value;
	}

}
?>