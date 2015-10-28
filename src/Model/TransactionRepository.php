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
		if ($query = $this->mysqli_wrapper->get()->prepare($statement)) {
			/* bind parameters for markers */
    		$query->bindParam(":customerId", $customerId);
    		$transactions = $this->execute($query);

    		return $transactions;
    	}
	}
}