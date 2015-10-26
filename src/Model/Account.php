<?php
namespace Model;
/**
 * the Account model class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class Account {
	private $id = 0;
	private $account_id = 0;
	private $customer_id = 0;
	private $is_active = 0;
	/**
	 * Gets the id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Sets the id
	 *
	 * @param integer $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	/**
	 * Gets the account id
	 *
	 * @return integer
	 */
	public function getAccountId() {
		return $this->account_id;
	}
	/**
	 * Sets the account id
	 *
	 * @param integer $AccountId
	 */
	public function setAccountId($accountId) {
		$this->account_id = $accountId;
	}
	/**
	 * Gets the customer id
	 *
	 * @return integer
	 */
	public function getCustomerId() {
		return $this->customer_id;
	}
	/**
	 * Sets the customer id
	 *
	 * @param integer $customerId
	 */
	public function setCustomerId($customerId) {
		$this->customer_id = $customerId;
	}
	/**
	 * Gets the active status of the account
	 *
	 * @return integer
	 */
	public function getIsActive() {
		return $this->is_active;
	}
	/**
	 * Sets the active status of the account
	 *
	 * @param integer $isActive
	 */
	public function setIsActive($isActive) {
		$this->is_active = $isActive;
	}
}