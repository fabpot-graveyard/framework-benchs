<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Resource;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
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
 * The Resource Manager
 *
 * @version $Id: ResourceManager.php 3769 2010-01-27 17:32:20Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class ResourceManager {

	/**
	 * @var \F3\FLOW3\Object\ObjectFactoryInterface
	 */
	protected $objectFactory;

	/**
	 * @var \F3\FLOW3\Reflection\ReflectionService
	 */
	protected $reflectionService;

	/**
	 * @var \F3\FLOW3\Resource\Publishing\ResourcePublisher
	 */
	protected $resourcePublisher;

	/**
	 * @var \F3\FLOW3\Utility\Environment
	 */
	protected $environment;

	/**
	 * @var \F3\FLOW3\Cache\Frontend\StringFrontend
	 */
	protected $statusCache;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var string
	 */
	protected $persistentResourcesStorageBaseUri;

	/**
	 * Injects the cache manager
	 *
	 * @param \F3\FLOW3\Object\ObjectFactoryInterface $objectFactory
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function injectObjectFactory(\F3\FLOW3\Object\ObjectFactoryInterface $objectFactory) {
		$this->objectFactory = $objectFactory;
	}

	/**
	 * Injects the resource publisher
	 *
	 * @param \F3\FLOW3\Resource\Publishing\ResourcePublisher $resourcePublisher
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function injectResourcePublisher(\F3\FLOW3\Resource\Publishing\ResourcePublisher $resourcePublisher) {
		$this->resourcePublisher = $resourcePublisher;
	}

	/**
	 * Injects the reflection service
	 *
	 * @param \F3\FLOW3\Reflection\ReflectionService $reflectionService
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function injectReflectionService(\F3\FLOW3\Reflection\ReflectionService $reflectionService) {
		$this->reflectionService = $reflectionService;
	}

	/**
	 * Injects the environment
	 *
	 * @param \F3\FLOW3\Utility\Environment $environment
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function injectEnvironment(\F3\FLOW3\Utility\Environment $environment) {
		$this->environment = $environment;
	}

	/**
	 * Injects the status cache
	 *
	 * @param \F3\FLOW3\Cache\Frontend\StringFrontend $statusCache
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function injectStatusCache(\F3\FLOW3\Cache\Frontend\StringFrontend $statusCache) {
		$this->statusCache = $statusCache;
	}

	/**
	 * Injects the settings of this package
	 *
	 * @param array $settings
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Check for implementations of F3\FLOW3\Resource\Streams\StreamWrapperInterface and
	 * register them.
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function initialize() {
		\F3\FLOW3\Resource\Streams\StreamWrapperAdapter::setObjectFactory($this->objectFactory);
		$streamWrapperClassNames = $this->reflectionService->getAllImplementationClassNamesForInterface('F3\FLOW3\Resource\Streams\StreamWrapperInterface');
		foreach ($streamWrapperClassNames as $streamWrapperClassName) {
			$scheme = $streamWrapperClassName::getScheme();
			if (in_array($scheme, stream_get_wrappers())) {
				stream_wrapper_unregister($scheme);
			}
			stream_wrapper_register($scheme, '\F3\FLOW3\Resource\Streams\StreamWrapperAdapter');
			\F3\FLOW3\Resource\Streams\StreamWrapperAdapter::registerStreamWrapper($scheme, $streamWrapperClassName);
		}

			// For now this URI is hardcoded, but might be manageable in the future
			// if additional persistent resources storages are supported.
		$this->persistentResourcesStorageBaseUri = FLOW3_PATH_DATA . 'Persistent/Resources/';
	}

	/**
	 * Imports a resource (file) from the given location as a persistent resource.
	 * On a successful import this method returns a Resource object representing the
	 * newly imported persistent resource.
	 *
	 * @param string $uri An URI (can also be a path and filename) pointing to the resource to import
	 * @return mixed A resource object representing the imported resource or FALSE if an error occurred.
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function importResource($uri) {
		$pathInfo = pathinfo($uri);
		if (!isset($pathInfo['extension']) || substr(strtolower($pathInfo['extension']), -3, 3) === 'php' ) {
			return FALSE;
		}

		$temporaryTargetPathAndFilename = $this->environment->getPathToTemporaryDirectory() . uniqid('FLOW3_ResourceImport_');
		if (copy($uri, $temporaryTargetPathAndFilename) === FALSE) {
			return FALSE;
		}

		$hash = sha1_file($temporaryTargetPathAndFilename);
		$finalTargetPathAndFilename = $this->persistentResourcesStorageBaseUri . $hash;
		if (rename($temporaryTargetPathAndFilename, $finalTargetPathAndFilename) === FALSE) {
			unlink($temporaryTargetPathAndFilename);
			return FALSE;
		}
		return $this->objectFactory->create('F3\FLOW3\Resource\Resource', $hash, $pathInfo['extension']);
	}

	/**
	 * Imports a resource (file) from the given upload info array as a persistent
	 * resource.
	 * On a successful import this method returns a Resource object representing
	 * the newly imported persistent resource.
	 *
	 * @param array $uploadInfo An array detailing the resource to import (expected keys: name, tmp_name)
	 * @return mixed A resource object representing the imported resource or FALSE if an error occurred.
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function importUploadedResource(array $uploadInfo) {
		$pathInfo = pathinfo($uploadInfo['name']);
		if (!isset($pathInfo['extension']) || substr(strtolower($pathInfo['extension']), -3, 3) === 'php' ) {
			return FALSE;
		}

		$hash = sha1_file($uploadInfo['tmp_name']);
		$finalTargetPathAndFilename = $this->persistentResourcesStorageBaseUri . $hash;
		if (move_uploaded_file($uploadInfo['tmp_name'], $finalTargetPathAndFilename) === FALSE) {
			return FALSE;
		}
		return $this->objectFactory->create('F3\FLOW3\Resource\Resource', $hash, $pathInfo['extension']);
	}

	/**
	 * Deletes the file represented by the given resource instance.
	 *
	 * @param \F3\FLOW3\Resource\Resource $resource
	 * @return boolean
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function deleteResource($resource) {
		if ($resource instanceof \F3\FLOW3\Resource\Resource) {
			if (is_file($this->persistentResourcesStorageBaseUri . $resource->getHash())) {
				unlink($this->persistentResourcesStorageBaseUri . $resource->getHash());
			}
		}
	}

	/**
	 * Method which returns the base URI of the location where persistent resources
	 * are stored.
	 *
	 * @return string The URI
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getPersistentResourcesStorageBaseUri() {
		return $this->persistentResourcesStorageBaseUri;
	}

	/**
	 * Prepares a mirror of public package resources that is accessible through
	 * the web server directly.
	 *
	 * @param array $activePackages
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function publishPublicPackageResources(array $activePackages) {
		if ($this->settings['resource']['publishing']['detectPackageResourceChanges'] === FALSE && $this->statusCache->has('packageResourcesPublished')) {
			return;
		}
		foreach ($activePackages as $packageKey => $package) {
			$this->resourcePublisher->publishStaticResources($package->getResourcesPath() . 'Public/', 'Packages/' . $packageKey . '/');
		}
		if (!$this->statusCache->has('packageResourcesPublished')) {
			$this->statusCache->set('packageResourcesPublished', 'y', array(\F3\FLOW3\Cache\Frontend\FrontendInterface::TAG_PACKAGE));
		}
	}
}

?>