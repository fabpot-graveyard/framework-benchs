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
 * An electronic address
 *
 * @version $Id: ElectronicAddress.php 3626 2010-01-14 12:21:48Z robert $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class ElectronicAddress {

	const TYPE_AIM = 'AIM';
	const TYPE_EMAIL = 'EMAIL';
	const TYPE_GIZMO = 'GIZMO';
	const TYPE_ICQ = 'ICQ';
	const TYPE_JABBER = 'JABBER';
	const TYPE_MSN = 'MSN';
	const TYPE_SIP = 'SIP';
	const TYPE_SKYPE = 'SKYPE';
	const TYPE_URL = 'URL';
	const TYPE_XRI = 'XRI';
	const TYPE_YAHOO = 'YAHOO';

	const USAGE_HOME = 'HOME';
	const USAGE_WORK = 'WORK';

	/**
	 * @var string
	 * @validate StringLength(minimum = 1, maximum = 255)
	 */
	protected $identifier;

	/**
	 * @var string
	 * @validate Alphanumeric, StringLength(minimum = 1, maximum = 20)
	 */
	protected $type;

	/**
	 * @var string
	 * @validate Alphanumeric, StringLength(minimum = 1, maximum = 20)
	 */
	protected $usage;

	/**
	 * @var boolean
	 */
	protected $approved = FALSE;

	/**
	 * Sets the identifier (= the value) of this electronic address.
	 *
	 * Example: john@example.com
	 *
	 * @param string $identifier The identifier
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
	}

	/**
	 * Returns the identifier (= the value) of this electronic address.
	 *
	 * @return string The identifier
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 *
	 * @return <type>
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 *
	 * @param <type> $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 *
	 * @return <type>
	 */
	public function getUsage() {
		return $this->usage;
	}

	/**
	 *
	 * @param <type> $usage 
	 */
	public function setUsage($usage) {
		$this->usage = $usage;
	}

	/**
	 *
	 * @param <type> $approved
	 */
	public function setApproved($approved) {
		$this->approved = $approved ? TRUE : FALSE;
	}

	/**
	 *
	 * @return <type>
	 */
	public function isApproved() {
		return $this->approved;
	}

	/**
	 * An alias for getIdentifier()
	 *
	 * @return string The identifier of this electronic address
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function  __toString() {
		return $this->identifier;
	}
}
?>