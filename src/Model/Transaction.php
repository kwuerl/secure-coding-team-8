<?php
namespace Model;
/**
 * the Transaction model class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class Transaction {
	private $transaction_id = 0;
	private $from_account_id = 0;
	private $to_account_id = 0;
	private $to_account_name = "";
	private $amount = 0;
	private $date = "";
	private $remarks = "";
	/**
	 * Constructor
	 */
	function __construct() {
		
	}
	/**
	 * Gets the transaction id
	 *
	 * @return integer
	 */
	public function getTransactionId() {
		return $this->transaction_id;
	}
	/**
	 * Sets the transaction id
	 *
	 * @param integer $transactionId
	 */
	public function setTransactionId($transactionId) {
		$this->transaction_id = $transactionId;
	}
	/**
	 * Gets the from account id
	 *
	 * @return integer
	 */
	public function getFromAccountId() {
		return $this->from_account_id;
	}
	/**
	 * Sets the from account id
	 *
	 * @param integer $fromAccountId
	 */
	public function setFromAccountId($fromAccountId) {
		$this->from_account_id = $fromAccountId;
	}
	/**
	 * Gets the to account id
	 *
	 * @return integer
	 */
	public function getToAccountId() {
		return $this->to_account_id;
	}
	/**
	 * Sets the to account id
	 * 
	 * @param integer $toAccountId
	 */
	public function setToAccountId($toAccountId) {
		$this->to_account_id = $toAccountId;
	}
	/**
	 * Gets the to account name
	 *
	 * @return string
	 */
	public function getToAccountName() {
		return $this->to_account_name;
	}
	/**
	 * Sets the to account name
	 * 
	 * @param string $toAccountName
	 */
	public function setToAccountName($toAccountName) {
		$this->to_account_name = $toAccountName;
	}
	/**
	 * Gets the transaction amount
	 *
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
	}
	/**
	 * Sets the transaction amount
	 * 
	 * @param float $amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	/**
	 * Gets the transaction date
	 *
	 * @return string
	 */
	public function getDate() {
		return $this->date;
	}
	/**
	 * Sets the transaction date
	 * 
	 * @param string $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	/**
	 * Gets the remarks
	 *
	 * @return string
	 */
	public function getRemarks() {
		return $this->remarks;
	}
	/**
	 * Sets the remarks
	 * 
	 * @param string $remarks
	 */
	public function setRemarks($remarks) {
		$this->remarks = $remarks;
	}
}