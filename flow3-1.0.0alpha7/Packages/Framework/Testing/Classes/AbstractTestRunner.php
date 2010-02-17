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

include_once('PHPUnit/Util/Filesystem.php');
include_once('PHPUnit/Util/Log/CodeCoverage/XML/Clover.php');
include_once('PHPUnit/Util/CodeCoverage.php');
include_once('PHPUnit/Util/Report.php');

/**
 * A preliminary test runner for TYPO3s unit tests
 *
 * @version $Id: AbstractTestRunner.php 3643 2010-01-15 14:38:07Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 */
abstract class AbstractTestRunner {

	/**
	 * @var integer
	 */
	const TYPE_UNIT = 1;
	const TYPE_INTEGRATION = 2;
	const TYPE_SYSTEM = 3;

	/**
	 * @var \F3\FLOW3\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \F3\FLOW3\Object\ObjectManagerInterface
	 */
	public static $objectManagerForTesting;

	/**
	 * @var \PHPUnit_Framework_TestSuite
	 */
	protected $testSuite;

	/**
	 * @var string
	 */
	protected $packagesPath;

	/**
	 * @var array
	 */
	protected $testBlacklist = array('PHPUnit');

	/**
	 * @var string
	 */
	protected $packageKey = '*';

	/**
	 * @var string
	 */
	protected $testcaseClassName = '';

	/**
	 * @var string
	 */
	protected $testOutputPath = './';

	/**
	 * @var string
	 */
	protected $coverageOutputPath = './coverage/';

	/**
	 * @var boolean
	 */
	protected $collectCodeCoverage = FALSE;

	/**
	 * Constructor
	 *
	 * @param  \F3\FLOW3\Object\ObjectManagerInterface $objectManager A reference to the object manager
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function __construct(\F3\FLOW3\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;

		$FLOW3 = new \F3\FLOW3\Core\Bootstrap('Testing');
		$FLOW3->initializeClassLoader();
		$FLOW3->initializeConfiguration();
		$FLOW3->initializeErrorHandling();
		$FLOW3->initializeObjectManager();

		$objectManagerReflection = new \ReflectionProperty($FLOW3, 'objectManager');
		$objectManagerReflection->setAccessible(TRUE);
		self::$objectManagerForTesting = $objectManagerReflection->getValue($FLOW3);

		$loggerReflection = new \ReflectionProperty($FLOW3, 'systemLogger');
		$loggerReflection->setAccessible(TRUE);
		$loggerReflection->setValue($FLOW3, $this->objectManager->getObject('F3\FLOW3\Log\LoggerFactory')->create('testLogger', 'F3\FLOW3\Log\Logger', array('F3\FLOW3\Log\Backend\NullBackend')));

		$FLOW3->initializePackages();
		$FLOW3->initializeSignalsSlots();
		$FLOW3->initializeCache();
		$FLOW3->initializeReflection();
		$FLOW3->initializeObjects();
		$FLOW3->initializeAOP();
		$FLOW3->initializePersistence();

		self::$objectManagerForTesting->setObjectClassName('F3\FLOW3\Session\SessionInterface', 'F3\FLOW3\Session\TransientSession');
		$FLOW3->initializeSession();
	}

	/**
	 * Setter for the package key of the package to test, * means all.
	 *
	 * @param string $packageKey
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setPackageKey($packageKey) {
		$this->packageKey = $packageKey;
	}

	/**
	 * Setter for the testcase class name, empty means all.
	 *
	 * @param string $testcaseClassName
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setTestcaseClassName($testcaseClassName) {
		$this->testcaseClassName = $testcaseClassName;
	}

	/**
	 * Setter for where the test output should go
	 *
	 * @param string $testTypes
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setTestOutputPath($testTypes) {
		$this->testOutputPath = $testTypes;
	}

	/**
	 * Setter for where the coverage output should go
	 *
	 * @param string $path
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setCoverageOutputPath($path) {
		if (!is_dir($path)) {
			\F3\FLOW3\Utility\Files::createDirectoryRecursively($path);
		}
		$this->coverageOutputPath = $path;
	}

	/**
	 * Enables collection of code coverage during test run
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function enableCodeCoverage() {
		$this->collectCodeCoverage = TRUE;
		$this->initializePHPUnitFilter();
	}

	/**
	 * Setter for the test types to include (array of self::TYPE_* constants)
	 *
	 * @param array $testTypes
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setTestTypes(array $testTypes) {
		$this->testTypes = $testTypes;
	}

	/**
	 * Main function - runs the tests
	 *
	 * @param string $packageKey
	 * @param string $outputPath
	 * @return void
	 */
	abstract public function run();

	/**
	 * Traverses the Tests directory of the given package and returns an
	 * array of filenames (including path) of all files ending with "Test.php".
	 *
	 * @return array Filenames of all found testcase files
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getTestcaseFilenames() {
		$packageManager = $this->objectManager->getObject('F3\FLOW3\Package\PackageManagerInterface');
		$packages = array();
		$testcaseFilenames = array(self::TYPE_UNIT => array(), self::TYPE_INTEGRATION => array(), self::TYPE_SYSTEM => array());

		$testcaseClassNameMatches = array();
		preg_match('/F3\\\\([^\\\\]*)\\\\(.*)/', $this->testcaseClassName, $testcaseClassNameMatches);
		if (count($testcaseClassNameMatches) === 3) {
			$this->testcaseClassName = $testcaseClassNameMatches[2];
			if ($testcaseClassNameMatches[1] === '.*') {
				$packages = $packageManager->getActivePackages();
			} elseif ($packageManager->isPackageActive($testcaseClassNameMatches[1])) {
				$packages = array($packageManager->getPackage($testcaseClassNameMatches[1]));
			}
		} elseif ($this->packageKey == '*') {
			$packages = $packageManager->getActivePackages();
			$this->testcaseClassName = '.*Test';
		} elseif ($packageManager->isPackageActive($this->packageKey)) {
			$packages = array($packageManager->getPackage($this->packageKey));
			$this->testcaseClassName = '.*Test';
		}

		shuffle($packages);
		foreach ($packages as $package) {
			if (in_array($package->getPackageKey(), $this->testBlacklist)) {
				continue;
			}
			foreach (array(
					self::TYPE_UNIT => \F3\FLOW3\Package\Package::DIRECTORY_TESTS_UNIT,
					self::TYPE_INTEGRATION => \F3\FLOW3\Package\Package::DIRECTORY_TESTS_INTEGRATION,
					self::TYPE_SYSTEM => \F3\FLOW3\Package\Package::DIRECTORY_TESTS_SYSTEM,
				) as $type => $directory) {
				$testPath = $package->getPackagePath() . $directory;
				if (is_dir($testPath)) {
					try {
						$testsDirectoryIterator = new \RecursiveDirectoryIterator($testPath);

						$testcaseFilenames[$type] = $this->readDirectories($testcaseFilenames[$type], $testsDirectoryIterator);
						\PHPUnit_Util_Filter::removeDirectoryFromFilter($package->getPackagePath() . 'Classes');
					} catch(\Exception $exception) {
						throw new \RuntimeException($exception->getMessage(), 1170236926);
					}
				}
				shuffle($testcaseFilenames[$type]);
			}
		}
		return $testcaseFilenames;
	}

	/**
	 * Reads all test files from base directory and subdirecotries
	 *
	 * @param array $testcaseFilenames array to store found testcases
	 * @param object $testsDirectoryIterator RecursiveDirectoryIterator object
	 * @return array Filenames of all found testcase files
	 * @author Ronny Unger <ru@php-workx.de>
	 */
	protected function readDirectories(array $testcaseFilenames, $testsDirectoryIterator) {
		while ($testsDirectoryIterator->valid()) {
			if ($testsDirectoryIterator->hasChildren() && $testsDirectoryIterator->getFilename() != '.svn') {
				$testcaseFilenames = $this->readDirectories($testcaseFilenames, $testsDirectoryIterator->getChildren());
			}
			if (!$testsDirectoryIterator->isDir()) {
				$pathAndFilename = \F3\FLOW3\Utility\Files::getUnixStylePath($testsDirectoryIterator->getPathname());
				if (preg_match('/\/' . str_replace('\\', '\\/', $this->testcaseClassName) . '\.php/', $pathAndFilename) === 1) {
					$testcaseFilenames[] = $pathAndFilename;
				}
			}
			$testsDirectoryIterator->next();
		}

		return $testcaseFilenames;
	}

	/**
	 * Adds the FLOW3 root and everything in the include_path to the PHPUnit filter,
	 * so it won't be considered when collecting code coverage data.
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function initializePHPUnitFilter() {
		\PHPUnit_Util_Filter::addDirectoryToFilter(FLOW3_PATH_ROOT);
		foreach(explode(':', ini_get('include_path')) as $include_path) {
			if(is_dir($include_path)) {
				\PHPUnit_Util_Filter::addDirectoryToFilter($include_path);
			}
		}
	}

	/**
	 * require() each of the testcase files if the corresponding test type is
	 * enabled.
	 *
	 * @param array $allTestcaseFileNamesAndPaths
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function requireTestCaseFiles(array $allTestcaseFileNamesAndPaths) {
		foreach ($allTestcaseFileNamesAndPaths as $type => $testcaseFileNamesAndPaths) {
			if (in_array($type, $this->testTypes)) {
				foreach ($testcaseFileNamesAndPaths as $filenameAndPath) {
					require($filenameAndPath);
				}
			}
		}
	}

}

?>