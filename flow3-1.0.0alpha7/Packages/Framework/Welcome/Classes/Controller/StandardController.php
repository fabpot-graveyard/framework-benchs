<?php
declare(ENCODING = 'utf-8');
namespace F3\Welcome\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Welcome".                    *
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
 * Controller with a welcome start screen for FLOW3
 *
 * @version $Id: StandardController.php 3643 2010-01-15 14:38:07Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class StandardController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @var \F3\FLOW3\Package\PackageManagerInterface
	 * @inject
	 */
	protected $packageManager;

	/**
	 * Index action
	 *
	 * @return void
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function indexAction() {
		$this->view->assign('flow3PathRoot', realpath(FLOW3_PATH_ROOT));
		$this->view->assign('flow3PathWeb', realpath(FLOW3_PATH_WEB));
		$this->view->assign('myPackageUrl', $this->uriBuilder->uriFor('index', array(), 'Standard', 'MyPackage'));
		$this->view->assign('isWindows', $this->isWindows());

		$flow3Package = $this->packageManager->getPackage('FLOW3');
		$version = $flow3Package->getPackageMetaData()->getVersion();
		$this->view->assign('version', $version);

		$activePackages = $this->packageManager->getActivePackages();
		$this->view->assign('activePackages', $activePackages);

		$this->view->assign('notDevelopmentContext', $this->objectManager->getContext() !== 'Development');
	}

	/**
	 * Determines whether FLOW3 runs on a Windows machine.
	 * @todo this might be a useful static method for F3/FLOW3/Utility/Environment
	 *
	 * @return boolean TRUE if current OS is Windows based, otherwise FALSE.
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	protected function isWindows() {
		return (strtolower(substr(PHP_OS, 0, 3)) === 'win');
	}

	/**
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function redirectAction() {
		$this->redirect('index');
	}
}
?>