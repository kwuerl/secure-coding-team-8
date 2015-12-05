<?php
namespace Model;
/**
 * the Transaction model class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Vivek Sethia <vivek.sethia@tum.de>
 */
class Transaction {
	private $id = 0;
	private $from_account_id = 0;
	private $from_account_name = "";
	private $to_account_id = 0;
	private $to_account_name = "";
	private $amount = 0;
	private $transaction_date = "";
	private $remarks = "";
	private $is_on_hold = 0;
	private $is_closed = 0;
	private $is_rejected = 0;
	/**
	 * Gets the transaction id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Sets the transaction id
	 *
	 * @param integer $transactionId
	 */
	public function setId($transactionId) {
		$this->id = $transactionId;
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
	public function getTransactionDate() {
		return $this->transaction_date;
	}
	/**
	 * Sets the transaction date
	 *
	 * @param string $transactionDate
	 */
	public function setTransactionDate($transactionDate) {
		$this->transaction_date = $transactionDate;
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
	/**
	 * Gets the on-hold status of the transaction
	 *
	 * @return integer
	 */
	public function getIsOnHold() {
		return $this->is_on_hold;
	}
	/**
	 * Sets the on-hold status of the transaction
	 *
	 * @param integer $isOnHold
	 */
	public function setIsOnHold($isOnHold) {
		$this->is_on_hold = $isOnHold;
	}
	/**
	 * Gets the closed status of the transaction
	 *
	 * @return integer
	 */
	public function getIsClosed() {
		return $this->is_closed;
	}
	/**
	 * Sets the closed status of the transaction
	 *
	 * @param integer $isClosed
	 */
	public function setIsClosed($isClosed) {
		$this->is_closed = $isClosed;
	}
	/**
	 * Gets the rejected status of the transaction
	 *
	 * @return integer
	 */
	public function getIsRejected() {
		return $this->is_rejected;
	}
	/**
	 * Sets the rejected status of the transaction
	 *
	 * @param integer $isRejected
	 */
	public function setIsRejected($isRejected) {
		$this->is_rejected = $isRejected;
	}

	/**
	 * Gets the from account name  of the transaction
	 *
	 * @return integer
	 */
	public function getFromAccountName() {
		return $this->from_account_name;
	}
	/**
	 * Sets the from account name of the transaction
	 *
	 * @param integer $fromAccountName
	 */
	public function setFromAccountName($fromAccountName) {
		$this->from_account_name = $fromAccountName;
	}
}