<?php
namespace Model;
/**
 * The Customer model class
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */
class Customer extends User {
	private $address;
	private $city;
	private $postal_code;
	private $is_account_balance_initialized = 0;
	private $tan_method;

	/**
	 * Gets the customer address
	 *
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}
	/**
	 * Sets the customer address
	 *
	 * @param string $address
	 */
	public function setAddress($address) {
		$this->address = $address;
	}
	/**
	 * Gets the customer city
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}
	/**
	 * Sets the customer city
	 *
	 * @param string $city
	 */
	public function setCity($city) {
		$this->city = $city;
	}
	/**
	 * Gets the customer postal code
	 *
	 * @return integer
	 */
	public function getPostalCode() {
		return $this->postal_code;
	}
	/**
	 * Sets the customer postal code
	 *
	 * @param string $postalCode
	 */
	public function setPostalCode($postalCode) {
		$this->postal_code = $postalCode;
	}
	/**
	 * Gets the balance initialized status of the User account
	 *
	 * @return integer
	 */
	public function getIsAccountBalanceInitialized () {
		return $this->is_account_balance_initialized;
	}
	/**
	 * Sets the balance initialized status of the User account
	 *
	 * @param integer $isBalanceInitialized
	 */
	public function setIsAccountBalanceInitialized($isAccountBalanceInitialized) {
		$this->is_account_balance_initialized = $isAccountBalanceInitialized;
	}

	/**
	 * Gets tan method for the User account
	 *
	 * @return integer
	 */
	public function getTanMethod () {
		return $this->tan_method;
	}
	/**
	 * Sets the tan method for the User account
	 *
	 * @param integer $tanMethod
	 */
	public function setTanMethod($tanMethod) {
		$this->tan_method = $tanMethod;
	}
}