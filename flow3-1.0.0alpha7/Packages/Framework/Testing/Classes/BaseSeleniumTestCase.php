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

require_once ('PHPUnit/Framework.php');
require_once ('PHPUnit/Extensions/SeleniumTestCase.php');

/**
 * The mother of all selenium test cases.
 *
 * @version $Id: BaseSeleniumTestCase.php 3323 2009-10-15 10:44:28Z k-fish $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
abstract class BaseSeleniumTestCase extends \PHPUnit_Extensions_SeleniumTestCase {

	/**
	 * Disable the backup and restoration of the $GLOBALS array.
	 */
	protected $backupGlobals = FALSE;

	/**
	 * Enable or disable the backup and restoration of static attributes.
	 */
	protected $backupStaticAttributes = FALSE;

	/**
	 * Make sure warnings end up as errors.
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function runBare() {
		\PHPUnit_Framework_Error_Warning::$enabled = FALSE;
		parent::runBare();
	}

}
?>