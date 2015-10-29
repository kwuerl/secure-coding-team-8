<?php
namespace Model;
/**
 * the TransactionCode model class
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class TransactionCode {
	private $id = 0;
	private $customer_id = 0;
	private $code = "";
	private $is_used = false;
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
	 * Gets the code
	 *
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}
	/**
	 * Sets the code
	 *
	 * @param string $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}
	/**
	 * Gets the used property
	 *
	 * @return boolean
	 */
	public function getIsUsed() {
		return $this->is_used;
	}
	/**
	 * Sets the used property
	 *
	 * @param boolean $isUsed
	 */
	public function setIsUsed($isUsed) {
		$this->is_used = $isUsed;
	}
}