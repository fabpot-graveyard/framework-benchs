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

require_once('PHPUnit/Framework.php');

/**
 * The mother of all test cases.
 *
 * Subclass this base class if you want to take advantage of the framework
 * capabilities, for example are in need of the object manager.
 *
 * @version $Id: BaseTestCase.php 3643 2010-01-15 14:38:07Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @api
 */
abstract class BaseTestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * Disable the backup and restoration of the $GLOBALS array.
	 */
	protected $backupGlobals = FALSE;

	/**
	 * Enable or disable the backup and restoration of static attributes.
	 */
	protected $backupStaticAttributes = FALSE;

	/**
	 * @var \F3\FLOW3\Object\ObjectManagerInterface The object manager
	 * @todo remove as soon as the tests are self-contained
	 */
	protected $objectManager;

	/**
	 * @var \F3\FLOW3\Object\ObjectFactoryInterface The object factory
	 * @todo remove as soon as the tests are self-contained
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
		\PHPUnit_Framework_Error_Warning::$enabled = FALSE;

		if (class_exists('F3\Testing\AbstractTestRunner', FALSE)) {
			$this->objectManager =  clone \F3\Testing\AbstractTestRunner::$objectManagerForTesting;
			$this->objectFactory = $this->objectManager->getObjectFactory();
		}
		parent::runBare();
	}

	/**
	 * Loads the supplied interface for PDO, so that it can be mocked.
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function loadPdoInterface() {
		if (!interface_exists('PdoInterface', FALSE)) {
			require(__DIR__ . '/../Resources/Private/PHP/PdoInterface.php');
		}
	}

	/**
	 * Creates a proxy class of the specified class which allows
	 * for calling even protected methods and access of protected properties.
	 *
	 * @param protected $className Full qualified name of the original class
	 * @return string Full qualified name of the built class
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	protected function buildAccessibleProxy($className) {
		$accessibleClassName = uniqid('AccessibleTestProxy');
		$class = new \ReflectionClass($className);
		$abstractModifier = $class->isAbstract() ? 'abstract ' : '';
		eval('
			' . $abstractModifier . 'class ' . $accessibleClassName . ' extends ' . $className . ' {
				public function _call($methodName) {
					return call_user_func_array(array($this, $methodName), array_slice(func_get_args(), 1));
				}
				public function _callRef($methodName, &$arg1 = NULL, &$arg2 = NULL, &$arg3 = NULL, &$arg4 = NULL, &$arg5= NULL, &$arg6 = NULL, &$arg7 = NULL, &$arg8 = NULL, &$arg9 = NULL) {
					switch (func_num_args()) {
						case 0 : return $this->$methodName();
						case 1 : return $this->$methodName($arg1);
						case 2 : return $this->$methodName($arg1, $arg2);
						case 3 : return $this->$methodName($arg1, $arg2, $arg3);
						case 4 : return $this->$methodName($arg1, $arg2, $arg3, $arg4);
						case 5 : return $this->$methodName($arg1, $arg2, $arg3, $arg4, $arg5);
						case 6 : return $this->$methodName($arg1, $arg2, $arg3, $arg4, $arg5, $arg6);
						case 7 : return $this->$methodName($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7);
						case 8 : return $this->$methodName($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8);
						case 9 : return $this->$methodName($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8, $arg9);
					}
				}
				public function _set($propertyName, $value) {
					$this->$propertyName = $value;
				}
				public function _setRef($propertyName, &$value) {
					$this->$propertyName = $value;
				}
				public function _get($propertyName) {
					return $this->$propertyName;
				}
			}
		');
		return $accessibleClassName;
	}
}
?>