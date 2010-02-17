<?php
declare(ENCODING = 'utf-8');
namespace F3\DocumentationBrowser\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "DocumentationBrowser".       *
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
 * Controller with a package list and documentation view
 *
 * @version $Id: StandardController.php 3643 2010-01-15 14:38:07Z robert $
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StandardController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @var \F3\FLOW3\Package\PackageManagerInterface
	 * @inject
	 */
	protected $packageManager;

	/**
	 * The index action displays an overview of package documentations, if
	 * the package key, documentation name and language are given, the
	 * documentation will be embedded.
	 *
	 * @param string $packageKey The package key (if selected)
	 * @param string $documentationName The documentation name (if selected)
	 * @param string $language The language (if selected)
	 * @return void
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 */
	public function indexAction($packageKey = '', $documentationName = '', $language = '') {
		$packageKey = $this->packageManager->getCaseSensitivePackageKey($packageKey);
		$renderedDocumentationByPackage = $this->getRenderedDocumentationsByPackages();
		if (count($renderedDocumentationByPackage) === 0) {
			$this->forward('empty');
		} else {
			$this->view->assign('renderedDocumentationByPackage', $renderedDocumentationByPackage);
			if ($packageKey != '' && $documentationName != '' && $language != '') {
				$viewDocumentationUri = $this->uriBuilder
					->reset()
					->uriFor('view',
						array(
							'packageKey' => $packageKey,
							'documentationName' => $documentationName,
							'language' => $language,
							'file' => 'index.html'
						)
					);
				$this->view->assign('viewDocumentationUri', $viewDocumentationUri);
				$this->view->assign('showDocumentation', TRUE);
				$this->view->assign('selectedPackageKey', $packageKey);
				$this->view->assign('selectedDocumentationName', $documentationName);
				$this->view->assign('selectedLanguage', $language);
			} else {
				$this->view->assign('showDocumentation', FALSE);
			}
		}
		$this->view->assign('baseUri', $this->request->getBaseUri());
	}

	/**
	 * Display a message for empty documentation (unrendered)
	 * @return void
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 */
	public function emptyAction() {

	}

	/**
	 * Aggregate rendered documentation and group by package key for easy iteration
	 * in the view.
	 *
	 * @return array The grouped documentation
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 */
	protected function getRenderedDocumentationsByPackages() {
		$activePackages = $this->packageManager->getActivePackages();
		$renderedDocumentationByPackage = array();
		foreach ($activePackages as $package) {
			$documentations = $package->getPackageDocumentations();
			foreach ($documentations as $documentation) {
				$formats = $documentation->getDocumentationFormats();
				if (isset($formats['HTML'])) {
					 if (!isset($renderedDocumentationByPackage[$package->getPackageKey()])) {
						$renderedDocumentationByPackage[$package->getPackageKey()] = array(
							'package' => $package,
							'documentations' => array()
						);
					}
					$renderedDocumentationByPackage[$package->getPackageKey()]['documentations'][] = $documentation;
				}
			}
		}
		return $renderedDocumentationByPackage;
	}

	/**
	 * The view action loads the file from the given documentation and
	 * acts as a proxy between the documentation browser and the private
	 * documentation, that is not directly accessible.
	 *
	 * @param string $packageKey The package key
	 * @param string $documentationName The documentation name
	 * @param string $language The language
	 * @param string $file The file to display
	 * @return string The file contents
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 */
	public function viewAction($packageKey, $documentationName, $language, $file) {
		$packageKey = $this->packageManager->getCaseSensitivePackageKey($packageKey);
		$package = $this->packageManager->getPackage($packageKey);
		$documentations = $package->getPackageDocumentations();
		foreach ($documentations as $iteratedDocumentationName => $iteratedDocumentation) {
			if (strtolower($iteratedDocumentationName) == strtolower($documentationName)) {
				$documentation = $iteratedDocumentation;
				break;
			}
		}
		if (!isset($documentation)) {
			return 'Documentation for ' . $packageKey . ' / ' . $documentationName . ' not found';
		}

		$formats = $documentation->getDocumentationFormats();
		if (!isset($formats['HTML'])) {
			return 'HTML documentation for ' . $packageKey . ' not found';
		}

		$format = $formats['HTML'];

		$contentType = $this->guessContentTypeByFilename($file);
		header('Content-Type: ' . $contentType);

		$path = $format->getFormatPath() . $language . '/' . $file;
		$path = dirname($path) . '/' . basename($path);

		if (strpos($path, $documentation->getDocumentationPath()) !== 0) {
			return 'Invalid file for documentation';
		}

		return file_get_contents($path);
	}

	/**
	 * Guess content type by filename
	 *
	 * @param string $filename The filename
	 * @return string The guessed content type
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 */
	protected function guessContentTypeByFilename($filename) {
		$extension = substr($filename, strrpos($filename, '.') + 1);
		switch ($extension) {
			case 'css' :
				$contentType = 'text/css';
				break;
			case 'gif' :
				$contentType = 'image/gif';
				break;
			case 'jpg' :
				$contentType = 'image/jpg';
				break;
			case 'png' :
				$contentType = 'image/png';
				break;
			default:
				$contentType = 'text/html';
		}
		return $contentType;
	}
}
?>