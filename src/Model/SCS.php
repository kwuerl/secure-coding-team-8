<?php
namespace Model;
/**
 * the SCS model class
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class SCS {
	private $id = 0;
	private $customer_id = 0;
	private $pin = "";
	/**
	 * Gets the id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Sets the id
	 *
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	/**
	 * Gets the customer id
	 *
	 * @return int
	 */
	public function getCustomerId() {
		return $this->customer_id;
	}
	/**
	 * Sets the customer id
	 *
	 * @param int $customer_id
	 */
	public function setCustomerId($customer_id) {
		$this->customer_id = $customer_id;
	}
	/**
	 * Gets the pin
	 *
	 * @return string
	 */
	public function getPin() {
		return $this->pin;
	}
	/**
	 * Sets the pin
	 *
	 * @param string $pin
	 */
	public function setPin($pin) {
		$this->pin = $pin;
	}
}