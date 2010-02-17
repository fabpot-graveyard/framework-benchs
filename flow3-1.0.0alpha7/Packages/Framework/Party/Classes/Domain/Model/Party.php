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
 * A party
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Party {

	/**
	 * @var SplObjectStorage
	 */
	protected $accounts;

	/**
	 * Constructor
	 *
	 * @return void
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function __construct() {
		$this->accounts = new \SplObjectStorage();
	}

	/**
	 * Assigns the given account to this party. Note: The internal reference of the account is
	 * set to this party.
	 *
	 * @return F3\Party\Domain\Model\Account $account The account
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function addAccount(\F3\Party\Domain\Model\Account $account) {
		$this->accounts->attach($account);
		$account->setParty($this);
	}

	/**
	 * Remove an account from this party
	 *
	 * @param F3\Party\Domain\Model\Account $account The account to remove
	 * @return void
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function removeAccount(\F3\Party\Domain\Model\Account $account) {
		$this->accounts->detach($account);
	}

	/**
	 * Returns the accounts of this party
	 *
	 * @return SplObjectStorage All assigned F3\Party\Domain\Model\Account objects
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function getAccounts() {
		return $this->accounts;
	}

}
?>