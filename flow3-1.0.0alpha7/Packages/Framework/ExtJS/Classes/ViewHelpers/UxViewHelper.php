<?php
declare(ENCODING = 'utf-8');
namespace F3\ExtJS\ViewHelpers;

/*                                                                        *
 * This script belongs to the FLOW3 package "ExtJS".                      *
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
 * ExtJS ux class inclusion view helper
 *
 * @version $Id: UxViewHelper.php 3548 2009-12-21 16:21:30Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @scope prototype
 * @api
 */
class UxViewHelper extends \F3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \F3\FLOW3\Resource\Publishing\ResourcePublisher
	 */
	protected $resourcePublisher;

	/**
	 * Inject the FLOW3 resource publisher.
	 *
	 * @param \F3\FLOW3\Resource\Publishing\ResourcePublisher $resourcePublisher
	 */
	public function injectResourcePublisher(\F3\FLOW3\Resource\Publishing\ResourcePublisher $resourcePublisher) {
		$this->resourcePublisher = $resourcePublisher;
	}

	/**
	 * Returns the HTML needed to include the ExtJS ux class.
	 *
	 * = Examples =
	 *
	 * <code title="Simple">
	 * {namespace ext=F3\ExtJS\ViewHelpers}
	 *  ...
	 * <ext:ux name="StatusBar"/>
	 * </code>
	 * Renders the script tag to include the StatusBar ux class.
	 *
	 * @param string $name The name of the ux class
	 * @return string HTML needed to include ExtJS
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @api
	 */
	public function render($name) {
		$baseUri = $this->resourcePublisher->getStaticResourcesWebBaseUri() . 'Packages/ExtJS/';
		return '
<script type="text/javascript" src="' . $baseUri . 'JavaScript/ux/' . $name . '.js"></script>
';
	}
}

?>
