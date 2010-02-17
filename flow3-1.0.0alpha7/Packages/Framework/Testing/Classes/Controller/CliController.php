<?php
declare(ENCODING = 'utf-8');
namespace F3\Testing\Controller;

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

/**
 * Controller for the test runner
 *
 * @version $Id: CliController.php 3644 2010-01-15 14:49:53Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CliController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * Defines the supported request types of this controller
	 *
	 * @var array
	 */
	protected $supportedRequestTypes = array('F3\FLOW3\MVC\CLI\Request');

	/**
	 * @var \F3\Testing\TestRunnerCommandLine
	 */
	protected $testRunner;

	/**
	 * The Testrunner has no view
	 *
	 * @return void
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	protected function resolveView() {
	}

	/**
	 * Injects the command line version of the test runner
	 *
	 * @param \F3\Testing\TestRunnerCommandLine $testRunner
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function injectTestRunnerCommandLine(\F3\Testing\TestRunnerCommandLine $testRunner) {
		$this->testRunner = $testRunner;
	}

	/**
	 * Processes a CLI request and returns help output.
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function indexAction() {
		return $this->helpAction();
	}

	/**
	 * Runs the test runner
	 *
	 * @param string $packageKey Package key to run tests for
	 * @param string $outputDirectory Where to put logfile.xml
	 * @param string $testcase Which testcase(s) to run (PCRE pattern)
	 * @param string $coverageDirectory Where to put the code coverage report (enables code converage if set)
	 * @param boolean $unit Run unit tests?
	 * @param boolean $integration Run integration tests?
	 * @param boolean $system Run system tests?
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function runAction($packageKey, $outputDirectory, $testcase = '', $coverageDirectory = '', $unit = TRUE, $integration = FALSE, $system = FALSE) {
		$testTypes = array();
		if ($unit) $testTypes[] = \F3\Testing\AbstractTestRunner::TYPE_UNIT;
		if ($integration) $testTypes[] = \F3\Testing\AbstractTestRunner::TYPE_INTEGRATION;
		if ($system) $testTypes[] = \F3\Testing\AbstractTestRunner::TYPE_SYSTEM;
		$this->testRunner->setTestTypes($testTypes);
		$this->testRunner->setPackageKey($packageKey);
		$this->testRunner->setTestCaseClassName($testcase);
		$this->testRunner->setTestOutputPath($outputDirectory);
		if ($coverageDirectory !== '') {
			$this->testRunner->setCoverageOutputPath($coverageDirectory);
			$this->testRunner->enableCodeCoverage();
		}
		$this->testRunner->run();
	}

	/**
	 * Returns a help message
	 *
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function helpAction() {
		return PHP_EOL .
			'FLOW3 Testrunner' . PHP_EOL .
			'Usage: php index.php testing cli run --package-key=PACKAGE --output-directory=DIRECTORY [--unit] [--integration] [--system] [--testcase=CLASSNAME ] [--coverage-directory=DIRECTORY]' . PHP_EOL
		;
	}
}

?>