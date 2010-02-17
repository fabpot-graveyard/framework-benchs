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
 * This is absolutely not programmed the way we want it later on, just preliminary!
 *
 * @version $Id: StandardController.php 3548 2009-12-21 16:21:30Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StandardController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * Defines the supported request types of this controller
	 *
	 * @var array
	 */
	protected $supportedRequestTypes = array('F3\FLOW3\MVC\Web\Request');

	/**
	 * @var \F3\Testing\TestRunnerWeb
	 * @inject
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
	 * Processes a (web-) request and returns the rendered page as a response
	 *
	 * @param string $packageToTest A package key as a filter (optional)
	 * @param string $testCaseClassName Class name of the test case to run (optional)
	 * @param boolean $collectCodeCoverageData If set to TRUE, code coverage data is collected (optional)
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function indexAction($packageToTest = '', $testCaseClassName = '', $collectCodeCoverageData = FALSE) {
		$this->testRunner->request = $this->request;

		if (!isset($_REQUEST['testTypes'])) {
			$this->testRunner->setTestTypes(array(\F3\Testing\AbstractTestRunner::TYPE_UNIT));
		} else {
			$this->testRunner->setTestTypes($_REQUEST['testTypes']);
		}

		$this->testRunner->setPackageKey($packageToTest);
		$this->testRunner->setTestCaseClassName($testCaseClassName);
		if($collectCodeCoverageData) {
			$this->testRunner->enableCodeCoverage();
			$this->testRunner->setCoverageOutputPath(FLOW3_PATH_WEB . '_Resources/CodeCoverageReport/');
		}

		$this->testRunner->run();
	}
}

?>