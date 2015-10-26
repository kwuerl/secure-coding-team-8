<?php
namespace Model;
/**
 * Repository class for the Account model
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class AccountRepository extends Repository {
    /**
     * Returns the Account Instance for customer id $customerId
     *
     * @param integer $customerId Customer ID to match
     *
     * @return Account $account Instance of the Account Model class
     */
	public function getByCustomerId ($customerId) {

		$statement = "SELECT TBL_ACCOUNT.*
		                FROM TBL_CUSTOMER, TBL_ACCOUNT
		                WHERE TBL_CUSTOMER.ID = TBL_ACCOUNT.CUSTOMER_ID
		                AND TBL_CUSTOMER.ID = ?";

		/* create a prepared statement */
		if ($query = $this->mysqli_wrapper->get()->prepare($statement)) {
			/* bind parameters for markers */
    		$query->bind_param("i", $customerId);
    		$account = $this->execute($query);
            /*Result will contain a single element and hence return it*/
    		return $account[0];
    	}
	}
}