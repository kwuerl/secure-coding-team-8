<?php
namespace Model;
/**
 * Repository class for the Transaction model
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
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
	 * Approve Transaction for the customer with particular transaction id
	 *
	 * @param integer $transactionId Id of the transaction
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function approveTransaction($transactionId) {
		$db = $this->db_wrapper->get();
		$transactionId = (int)$transactionId;
		$statement = "UPDATE
						TBL_TRANSACTION
						SET IS_ON_HOLD = 0 WHERE ID= :transactionId";

		if ($this->isClosed($transactionId)) {
			$error = _ERROR_TRANSACTION_CLOSED;
			return $error;
		}
		/* set autocommit to off */
		$db->beginTransaction();

		/* create a prepared statement */
		if ($query = $db->prepare($statement)) {
			/* bind parameters for markers */
			$query->bindParam(':transactionId', $transactionId);
			$query->execute();

			$db->commit();
			$error = $this->getError($db, true);
			if (!$error) {
				$this->close($transactionId);
			}
			return $error;
		}
	}
	/**
	 * Reject Transaction for the customer with particular transaction id
	 *
	 * @param integer $transactionId Id of the transaction
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function rejectTransaction($transactionId) {
		$db = $this->db_wrapper->get();
		$transactionId = (int)$transactionId;

		if ($this->isClosed($transactionId)) {
			$error = _ERROR_TRANSACTION_CLOSED;
			return $error;
		}
		$statement = "UPDATE
						TBL_TRANSACTION
						SET IS_REJECTED = 1, IS_ON_HOLD = 0 WHERE ID= :transactionId";

		$db->beginTransaction();

		/* create a prepared statement */
		if ($query = $db->prepare($statement)) {
			/* bind parameters for markers */
			$query->bindParam(':transactionId', $transactionId);
			$query->execute();

			$db->commit();
			$error = $this->getError($db, true);
			if (!$error) {
				$this->close($transactionId);
			}
			return $error;
		}
	}
	/**
	 * Closes the transaction indicating that actions have already been performed on it.
	 *
	 * @param integer $transactionId Id of the transaction
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function close($transactionId) {
		$db = $this->db_wrapper->get();
		$transactionId = (int)$transactionId;
		$statement = "UPDATE
						TBL_TRANSACTION
						SET IS_CLOSED = 1 WHERE ID= :transactionId";

		$db->beginTransaction();

		/* create a prepared statement */
		if ($query = $db->prepare($statement)) {
			/* bind parameters for markers */
			$query->bindParam(':transactionId', $transactionId);
			$query->execute();

			$db->commit();
			$error = $this->getError($db);
			return $error;
		}
	}

	/**
	 * Checks the closed status of the transaction
	 *
	 * @param integer $transactionId Id of the transaction
	 *
	 * @return integer $status Closed status of the transaction
	 */
	public function isClosed($transactionId) {
		$db = $this->db_wrapper->get();
		$transactionId = (int)$transactionId;
		$statement = "SELECT IS_CLOSED FROM
						TBL_TRANSACTION
						WHERE ID= :transactionId";

		/* create a prepared statement */
		if ($query = $db->prepare($statement)) {
			/* bind parameters for markers */
			$query->bindParam(':transactionId', $transactionId);
			$query->execute();

			$status = $query->fetchColumn();
			return $status;
		}
	}
	/**
	 * Gets the error from the database
	 *
	 * @param Connection $db Connection to the database
	 *
	 * @return string|boolean $error|false Returns the error message, if error exists and false otherwise
	 */
	private function getError($db, $isRollBack = false) {
		$error = $db->errorInfo();
		if (count($error) > 0 && !is_null($error[2])) {
			if ($isRollBack) {
				$db->rollBack();
			}
			return $error[2];
		}
		return false;
	}
}