<?php
namespace Model;
/**
 * The Customer model class
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class Customer extends User {
	private $address;
	private $city;
	private $postal_code;

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
}