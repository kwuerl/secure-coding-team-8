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
	 * Returns all Outgoing Transaction Instances for customer id $customerId
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
     * Returns all Transaction Instances for customer id $customerId
     *
     * @param integer $customerId Customer ID to match , $limit no of data to retrieve
     *
     * @return array $transactions Instances of the Transaction Model class
     */
    public function getAllByCustomerId($customerId, $limit = _NO_LIMIT) {
        $statement = "SELECT TBL_TRANSACTION.*
                        FROM TBL_ACCOUNT, TBL_TRANSACTION
                        WHERE (TBL_ACCOUNT.ACCOUNT_ID = TBL_TRANSACTION.FROM_ACCOUNT_ID
                        OR TBL_ACCOUNT.ACCOUNT_ID = TBL_TRANSACTION.TO_ACCOUNT_ID) AND TBL_TRANSACTION.IS_ON_HOLD = 0 AND TBL_TRANSACTION.IS_REJECTED = 0
                        AND TBL_ACCOUNT.CUSTOMER_ID = :customerId";
                        if ($limit)
                            $statement .= " LIMIT $limit ;";

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
	 * @param Repository $accountRepo Account Repository
	 * @param Model $fromAccount Account Instance
	 * @param Model $toAccount Account Instance
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function actOnTransaction($model, $action, $accountRepo = null, $fromAccount = null, $toAccount = null) {

		$db = $this->db_wrapper->get();
		$transaction_id = $model->getId();

		if ($model->getIsClosed() == 1) {
			$error = _ERROR_TRANSACTION_CLOSED;
			return $error;
		}
		switch($action) {
			case _ACTION_APPROVE:

				$db->beginTransaction();

				$model->setIsOnHold(0);
				$model->setIsClosed(1);
				$result = $this->update($model, array("is_on_hold", "is_closed"), array("id" => $transaction_id));

				if ($result == 1) {
					$result = $this->updateAccountBalance($db, $model, $accountRepo, $fromAccount, $toAccount);
					if (!$result) {
						$db->rollBack();
						return $result;
					}
					$db->commit();
				} else {
					$db->rollBack();
					return $result;
				}
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

	/**
	 * Handles actions required for performing a transfer/transaction
	 *
	 * @param Model $model Transaction Instance
	 * @param Repository $accountRepo Account Repository
	 * @param Model $fromAccount Account Instance
	 * @param Model $toAccount Account Instance
	 * @param Repository $transactionCodeRepo Transaction Code Repository
	 * @param Model $transactionCode Transaction Code Instance
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function makeTransfer($model, $accountRepo = null, $fromAccount = null, $toAccount = null, $transactionCodeRepo = null, $transactionCode = null) {

		$db = $this->db_wrapper->get();
		$db->beginTransaction();

		$result = $this->add($model);
		if ($result == 1) {
			if ($model->getIsOnHold() == 0) {
				$result = $this->updateAccountBalance($db, $model, $accountRepo, $fromAccount, $toAccount);
				if (!$result) {
					$db->rollBack();
					return $result;
				}
			}
			$customer_id = $fromAccount->getCustomerId();

			/*If the transaction code is a string i.e., _TAN_METHOD_SCS case, then create a new transaction code model and add it.*/
			if (is_string($transactionCode)) {
				$transaction_code_id = $transactionCode;
				$transactionCode = new TransactionCode();
				$transactionCode->setCustomerId($customer_id);
				$transactionCode->setCode($transaction_code_id);
				$transactionCode->setIsUsed(1);
				$result = $transactionCodeRepo->add($transactionCode);
			} else {/*Transaction code model already exists i.e., _TAN_METHOD_EMAIL case, then just update the model.*/
				$transaction_code_id = $transactionCode->getCode();
				$transactionCode->setIsUsed(1);
				$result = $transactionCodeRepo->update($transactionCode, array("is_used"), array("code" => $transaction_code_id, "customer_id" => $customer_id));
			}

			if (!$result) {
				$db->rollBack();
				return $result;
			}

			$db->commit();
		} else {
			$db->rollBack();
			return $result;
		}
		return ($result == 1) ? true : $result;
	}

	/**
	 * Updates the account balance
	 *
	 * @param DB Connection $db Database Connection
	 * @param Model $model Transaction Instance
	 * @param Repository $accountRepo Account Repository
	 * @param Model $fromAccount Account Instance
	 * @param Model $toAccount Account Instance
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	private function updateAccountBalance($db, $model, $accountRepo = null, $fromAccount = null, $toAccount = null) {
		if ($fromAccount) {
			$new_balance = $fromAccount->getBalance() - $model->getAmount();
			$fromAccount->setBalance((float)$new_balance);
			$result = $accountRepo->update($fromAccount, array("balance"), array("account_id" => $fromAccount->getAccountId()));
			if (!$result) {
				return $result;
			}
		}
		if ($toAccount) {
			$new_balance = $toAccount->getBalance() + $model->getAmount();
			$toAccount->setBalance((float)$new_balance);
			$result = $accountRepo->update($toAccount, array("balance"), array("account_id" => $toAccount->getAccountId()));
			if (!$result) {
				return $result;
			}
		}
		return true;
	}
}