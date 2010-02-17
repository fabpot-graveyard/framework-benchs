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
 * Extended version of the PHPUnit_Framework_TestListener
 *
 * @version $Id: TestListener.php 3760 2010-01-26 11:12:53Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 */
class TestListener implements \PHPUnit_Framework_TestListener {

	public $baseUri;
	protected $resultArray = array();
	protected $currentTestNumber = 0; // For counting the tests

	/**
	 * An error occurred.
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param Exception $e
	 * @param float $time
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
		$testCaseTraceArr = $this->getFirstNonPHPUnitTrace ($e->getTrace());
		$fileName = $testCaseTraceArr['file'];
		echo '<script type="text/javascript">document.getElementById("progress-bar").style.backgroundImage = "url(_Resources/Static/Packages/Testing/Media/indicator_red.gif)";</script>
			<div class="test error"><strong>Error</strong> in <em>'.$test->getName().'</em> ' .
			'<img src="_Resources/Static/Packages/Testing/Media/error.png" alt="Detail" onclick="if(document.getElementById(\'test'.$this->currentTestNumber.'\').style.display==\'none\') document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'block\'; else document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'none\'" />' .
			'<div class="testdetail" id="test'.$this->currentTestNumber.'">'.$fileName.':'.$testCaseTraceArr['line'].'<br />'.htmlspecialchars($e->getMessage()).'<br /><div class="testoutput">'.$this->getTestOutput().'</div></div></div>';
		$this->resultArray['error']++;

		$this->flushOutputBuffer();
	}

	/**
	 * A failure occurred.
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param PHPUnit_Framework_AssertionFailedError $e
	 * @param float $time
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time) {
		$testCaseTraceArr = $this->getFirstNonPHPUnitTrace ($e->getTrace());
		$fileName = $testCaseTraceArr['file'];
		echo '<script type="text/javascript">document.getElementById("progress-bar").style.backgroundImage = "url(_Resources/Static/Packages/Testing/Media/indicator_red.gif)";</script>
			<div class="test failure"><strong>Failure</strong> in <em>'.$test->getName().'</em> ' .
			'<img src="_Resources/Static/Packages/Testing/Media/failure.png" alt="Detail" onclick="if(document.getElementById(\'test'.$this->currentTestNumber.'\').style.display==\'none\') document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'block\'; else document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'none\'" />' .
			'<div class="testdetail" id="test'.$this->currentTestNumber.'">'.$fileName.':'.$testCaseTraceArr['line'].'<br />'.htmlspecialchars($e->getMessage()).'<br /><div class="testoutput">'.$this->getTestOutput().'</div></div></div>';
		$this->resultArray['failure']++;

		$this->flushOutputBuffer();
	}

	/**
	 * Incomplete test.
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param \Exception $e
	 * @param float $time
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
		echo '<div class="test incomplete"><strong>Incomplete test</strong> <em>'.$test->getName().'</em> ' .
			'<img src="_Resources/Static/Packages/Testing/Media/incomplete.png" alt="Detail" onclick="if(document.getElementById(\'test'.$this->currentTestNumber.'\').style.display==\'none\') document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'block\'; else document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'none\'" />' .
			'<div class="testdetail" id="test'.$this->currentTestNumber.'">'.$e->getFile().':'.$e->getLine().'<br />'.htmlspecialchars($e->getMessage()).'<br /><div class="testoutput">'.$this->getTestOutput().'</div></div></div>';
		$this->resultArray['incomplete']++;

		$this->flushOutputBuffer();
	}

	/**
	 * Skipped test.
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param \Exception $e
	 * @param float $time
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
		echo '<div class="test skipped"><strong>Skipped test</strong> <em>'.$test->getName().'</em> ' .
			'<img src="_Resources/Static/Packages/Testing/Media/skipped.png" alt="Detail" onclick="if(document.getElementById(\'test'.$this->currentTestNumber.'\').style.display==\'none\') document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'block\'; else document.getElementById(\'test'.$this->currentTestNumber.'\').style.display=\'none\'" />' .
			'<div class="testdetail" id="test'.$this->currentTestNumber.'">'.$e->getFile().':'.$e->getLine().'<br />'.htmlspecialchars($e->getMessage()).'<br /><div class="testoutput">'.$this->getTestOutput().'</div></div></div>';
		$this->resultArray['skipped']++;

		$this->flushOutputBuffer();
	}

	/**
	 * A testsuite started.
	 *
	 * @param PHPUnit_Framework_TestSuite $suite
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 */
	public function startTestSuite(\PHPUnit_Framework_TestSuite $suite) {
		$suiteName = $suite->getName();
		$suiteParts = explode('\\', $suiteName);
		$suiteClassName = '';
		for ($i = 0; $i < count($suiteParts); $i++) {
			$suitePart = $suiteParts[$i];
			if ($suiteClassName !== '') {
				$suiteClassName .= '\\' . $suitePart;
			} else {
				$suiteClassName = $suitePart;
			}
			if ($i < count($suiteParts) - 1) {
				$suiteClassNameFilter = $suiteClassName . '\\.*Test';
			} else {
				$suiteClassNameFilter = $suiteClassName;
			}
			$suiteLinks[] = '<a href="testing/?packageToTest=' . urlencode('*') . '&testCaseClassName=' . urlencode($suiteClassNameFilter) . '&' . http_build_query(array('testTypes' => $_REQUEST['testTypes'])) . '">' . $suitePart . '</a>';
		}
		echo '<div class="testsuite"><h2 class="testsuite">' . implode(' \\ ', $suiteLinks) . '</h2>';
		$this->resultArray = array('total' => 0, 'skipped' => 0, 'incomplete' => 0, 'failure' => 0, 'error' => 0);
	}

	/**
	 * A testsuite ended.
	 *
	 * @param PHPUnit_Framework_TestSuite $suite
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function endTestSuite(\PHPUnit_Framework_TestSuite $suite) {
		echo '<div class="testsuiteresults">Tests: '.$this->resultArray['total'].' total, '.$this->resultArray['skipped'].' skipped, '.$this->resultArray['incomplete'].' incomplete, '.$this->resultArray['failure'].' failed, '.$this->resultArray['error'].' errors</div></div>';

		$this->flushOutputBuffer();
	}

	/**
	 * A test started.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function startTest(\PHPUnit_Framework_Test $test) {
		$this->currentTestNumber ++;
		$this->resultArray['total']++;
		echo '<div class="singletest">';

		ob_start();
	}

	/**
	 * A test ended.
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function endTest(\PHPUnit_Framework_Test $test, $time) {
		$remainingOutput = @ob_get_clean();
		if(strlen($remainingOutput)) {
			echo '<div class="testoutput">'.$remainingOutput.'</div>';
		}
		echo '</div>';

		$this->flushOutputBuffer();
	}

	/**
	 * Returns the first trace information which is not caused by the PHPUnit file
	 * "Framework/Assert.php".
	 *
	 * @param array $traceArr The trace array
	 * @return array Trace information
	 * @author Robert Lemke <robert@typo3.org>
	 */
	protected function getFirstNonPHPUnitTrace($traceArr) {
		$testCaseTraceArr = array();
		foreach ($traceArr as $singleTraceArr) {
			if (isset($singleTraceArr['file'])) {
				if (!stristr ($singleTraceArr['file'], 'Framework/Assert.php')) {
					$testCaseTraceArr = $singleTraceArr;
					break;
				}
			}
		}
		return $testCaseTraceArr;
	}

	/**
	 * Fetches any test output from the output buffer. If xdebug is not enabled the output
	 * is run through htmlspecialchars() and nl2br() before it is returned.
	 *
	 * @return string HTML code of test output (if any)
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getTestOutput() {
		if(function_exists('xdebug_is_enabled') && xdebug_is_enabled()) {
			return @ob_get_clean();
		} else {
			return nl2br(htmlspecialchars(@ob_get_clean()));
		}
	}

	/**
	 * Flushes the output buffer (if needed)
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function flushOutputBuffer() {
		if (ob_get_length()) {
			@ob_flush();
			flush();
		}
	}
}

?>