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

require('PHPUnit/Util/Log/JUnit.php');

/**
 * A preliminary test runner for TYPO3s unit tests
 *
 * @version $Id: TestRunnerCommandLine.php 3760 2010-01-26 11:12:53Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 */
class TestRunnerCommandLine extends \F3\Testing\AbstractTestRunner {

	/**
	 * Initializes and runs the tests
	 *
	 * @param string $packageKey Package to test
	 * @param string $testcaseClassName Testcase to run (all if not given)
	 * @param string $outputPath Path to put the output XML files to
	 * @return void
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @internal Preliminary solution - there surely will be nicer ways to implement a test runner
	 */
	public function run() {
		$testResult = new \PHPUnit_Framework_TestResult;
		$testResult->addListener(new \PHPUnit_Util_Log_JUnit($this->testOutputPath . '/logfile.xml'));
		$testResult->collectCodeCoverageInformation($this->collectCodeCoverage);

		$testcaseFileNamesAndPaths = $this->getTestcaseFilenames();
		if (count($testcaseFileNamesAndPaths) > 0) {
			$this->requireTestCaseFiles($testcaseFileNamesAndPaths);

			$startTime = microtime(TRUE);
			foreach (get_declared_classes() as $className) {
				if (substr($className, -4, 4) == 'Test') {
					$class = new \ReflectionClass($className);
					if ($class->isSubclassOf('PHPUnit_Framework_TestCase') && substr($className, 0, 8) !== 'PHPUnit_') {
						$testSuite = new \PHPUnit_Framework_TestSuite($class);
						$testSuite->run($testResult);
					}
				}
			}
			$endTime = microtime(TRUE);

			$testResult->flushListeners();

				// Display test statistics:
			if ($testResult->wasSuccessful()) {
				echo 'SUCCESS' . PHP_EOL . $testResult->count().' tests, '.$testResult->failureCount().' failures, '.$testResult->errorCount().' errors.' . PHP_EOL;
			} else {
				echo 'FAILURE' . PHP_EOL . $testResult->count().' tests, '.$testResult->failureCount().' failures, '.$testResult->errorCount().' errors.' . PHP_EOL;
			}

			echo 'Peak memory usage was: ~' . floor(memory_get_peak_usage()/1024/1024) . ' MByte.' . PHP_EOL;
			echo 'Test run took ' . round(($endTime - $startTime), 4) . ' seconds.' . PHP_EOL;

			if ($this->collectCodeCoverage === TRUE) {
				$report = new \PHPUnit_Util_Log_CodeCoverage_XML_Clover($this->coverageOutputPath . '/clover.xml');
				$report->process($testResult);
			}
		} else {
			echo 'No testcase found. Did you specify the intended pattern?' . PHP_EOL;
		}
	}

}

?>
