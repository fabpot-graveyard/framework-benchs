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

/**
 * The mother of all integration test cases.
 *
 * Subclass this base class if you want to take advantage of the framework
 * capabilities, for example are in need of the object manager.
 *
 * @version $Id: BaseIntegrationTestCase.php 3643 2010-01-15 14:38:07Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
abstract class BaseIntegrationTestCase extends \F3\Testing\BaseTestCase {

	/**
	 * @var \F3\FLOW3\Object\ObjectManagerInterface The object manager
	 */
	protected $objectManager;

	/**
	 * @var \F3\FLOW3\Object\ObjectFactoryInterface The object factory
	 */
	protected $objectFactory;

	/**
	 * Injects an untainted clone of the object manager and all its referencing
	 * objects for every test.
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function runBare() {
		$this->objectManager =  clone \F3\Testing\AbstractTestRunner::$objectManagerForTesting;
		$this->objectFactory = $this->objectManager->getObjectFactory();
		parent::runBare();
	}

}
?>