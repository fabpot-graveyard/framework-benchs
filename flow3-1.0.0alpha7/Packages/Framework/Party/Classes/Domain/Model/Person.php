<?php
declare(ENCODING = 'utf-8');
namespace F3\Party\Domain\Model;

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
 * A person
 *
 * @version $Id: Person.php 3626 2010-01-14 12:21:48Z robert $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Person extends \F3\Party\Domain\Model\Party {

	/**
	 * @var \F3\Party\Domain\Model\PersonName
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * @var \SplObjectStorage<\F3\Party\Domain\Model\ElectronicAddress>
	 */
	protected $electronicAddresses;

	/**
	 * @var \F3\Party\Domain\Model\ElectronicAddress
	 */
	protected $primaryElectronicAddress;

	/**
	 * Constructs this Person
	 *
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function __construct() {
		parent::__construct();
		$this->electronicAddresses = new \SplObjectStorage();
	}

	/**
	 * Sets the current name of this person
	 * 
	 * @param \F3\Party\Domain\Model\PersonName $name Name of this person
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setName(\F3\Party\Domain\Model\PersonName $name) {
		$this->name = $name;
	}
	
	/**
	 * Returns the current name of this person
	 *
	 * @return \F3\Party\Domain\Model\PersonName Name of this person
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Adds the given electronic address to this person.
	 *
	 * @param \F3\Party\Domain\Model\ElectronicAddress $electronicAddress The electronic address
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function addElectronicAddress(\F3\Party\Domain\Model\ElectronicAddress $electronicAddress) {
		$this->electronicAddresses->attach($electronicAddress);
	}

	/**
	 * Removes the given electronic address from this person.
	 *
	 * @param \F3\Party\Domain\Model\ElectronicAddress $electronicAddress The electronic address
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function removeElectronicAddress(\F3\Party\Domain\Model\ElectronicAddress $electronicAddress) {
		$this->electronicAddresses->detach($electronicAddress);
		if ($electronicAddress === $this->primaryElectronicAddress) {
			unset($this->primaryElectronicAddress);
		}
	}

	/**
	 * Returns all known electronic addresses of this person.
	 *
	 * @return \SplObjectStorage<\F3\Party\Domain\Model\ElectronicAddress>
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getElectronicAddresses() {
		return clone $this->electronicAddresses;
	}

	/**
	 * Sets (and adds if necessary) the primary electronic address of this person.
	 * 
	 * @param \F3\Party\Domain\Model\ElectronicAddress $electronicAddress The electronic address
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setPrimaryElectronicAddress(\F3\Party\Domain\Model\ElectronicAddress $electronicAddress) {
		$this->primaryElectronicAddress = $electronicAddress;
		$this->electronicAddresses->attach($electronicAddress);
	}

	/**
	 * Returns the primary electronic address, if one has been defined.
	 *
	 * @return \F3\Party\Domain\Model\ElectronicAddress The primary electronic address or NULL
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getPrimaryElectronicAddress() {
		return $this->primaryElectronicAddress;
	}
}

?>