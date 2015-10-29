<?php
namespace Model;
/**
 * Repository class for the Transaction model
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */
class TransactionRepository extends Repository {
	/**
	 * Returns all Transaction Instances for customer id $customerId
	 *
	 * @param integer $customerId Customer ID to match
	 *
	 * @return array $transactions Instances of the Transaction Model class
	 */
	public function getByCustomerId($customerId) {
		$statement = "SELECT TBL_TRANSACTION.*
		 				FROM TBL_ACCOUNT, TBL_TRANSACTION
		 				WHERE TBL_ACCOUNT.ACCOUNT_ID = TBL_TRANSACTION.FROM_ACCOUNT_ID
		 				AND TBL_ACCOUNT.CUSTOMER_ID = :customerId";

		/* create a prepared statement */
		if ($query = $this->db_wrapper->get()->prepare($statement)) {
			/* bind parameters for markers */
    		$query->bindParam(":customerId", $customerId);
    		$transactions = $this->execute($query);

    		return $transactions;
    	}
	}
	/**
	 * Updates the the transaction status to approved or rejected
	 *
	 * @param Model $model Transaction Instance
	 * @param string $action Action to perform on the registration
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function actOnTransaction($model, $action) {

		$db = $this->db_wrapper->get();
		$transaction_id = $model->getId();

		if ($model->getIsClosed() == 1) {
			$error = _ERROR_TRANSACTION_CLOSED;
			return $error;
		}
		switch($action) {
			case _ACTION_APPROVE:
				$model->setIsOnHold(0);
				$model->setIsClosed(1);
				$result = $this->update($model, array("is_on_hold", "is_closed"), array("id" => $transaction_id));
				break;
			case _ACTION_REJECT:
				$model->setIsOnHold(0);
				$model->setIsRejected(1);
				$model->setIsClosed(1);
				$result = $this->update($model, array("is_on_hold", "is_rejected", "is_closed"), array("id" => $transaction_id));
				break;
		}
		return ($result == 1) ? "" : $result;
	}
}