<?php
namespace Controller;

/**
 * Transaction Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia <vivek.sethia@tum.de>
 */
class TransactionController extends Controller {

	public function makeTransfer($request) {
		$customer = $this->get("auth")->check(_GROUP_USER);

		// create the FormHelper
        $helper = new \Helper\FormHelper("make_transfer");
		//add one field
		$helper->addField("to_account_id", "text", array(
			array("required", "Beneficiary Account No. is required"),
		    array("number", "Only numbers are allowed"),
		), array("ltrim", "rtrim"), "");

		$helper->addField("to_account_name", "name", array(
			array("required", "Account Holder Name is required"),
			array("name", "Only letters, '-' and white space allowed and must be at least 2 characters")
		), array("ltrim", "rtrim"), "");

		$helper->addField("amount", "text", array(
			array("required", "Amount to be transfered should be specified"),
			//array("name", "Max. 50000 per day allowed"),
			array("maxLength", "Enter 15 digit transaction code", array(15))
		), array("ltrim", "rtrim"), "");

		$helper->addField("transaction_code", "text", array(
			array("required", "Transaction code is required"),
			array("maxLength", "Enter 15 digit transaction code", array(15))
		), array("ltrim", "rtrim"), "");

		$helper->addField("remarks", "text", array(
			array("required", "Remarks is required"),
			array("maxLength", "Max. 100 characters allowed", array(100))
		), array("ltrim", "rtrim"), "");

		// process the request
		if ($helper->processRequest($request)) {
			//try to validate
			if ($helper->validate()) {
			    $transaction_code = $request->getData('make_transfer')['transaction_code'];
			    $customer_id = $customer->getId();
			    $account_repo = $this->get('account_repository');
			    $transaction_code_repo = $this->get('transaction_code_repository');
				$is_valid_transaction = $transaction_code_repo->findOne(array("customer_id" => $customer_id, "code" => $transaction_code, "is_used" => 0));

				// Checking whether the transaction is valid , then proceed further
				if (!empty($is_valid_transaction)) {
					// fill the model
					$model = new \Model\Transaction();
					$helper->fillModel($model);

					$model->setTransactionDate(date("Y-m-d H:i:s"));
					$from_account = $account_repo->findOne(array("customer_id" => $customer_id));
					$to_account = $account_repo->findOne(array("account_id" => $model->getToAccountId()));
					$from_account_id = $from_account->getAccountId();
					$model->setFromAccountId($from_account_id);

					// check whether the amount > 10000
					if( $request->getData('make_transfer')['amount'] > _TRANSFER_LIMIT_FOR_AUTO_APPROVAL ){
						$model->setIsOnHold(1);
					}

					// add to transaction repository
					if ($this->get('transaction_repository')->makeTransfer($model, $account_repo, $from_account, $to_account, $transaction_code_repo, $is_valid_transaction)) {
						// after successful transfer , redirect to make_transfer page
						$this->get("flash_bag")->add(_OPERATION_SUCCESS, "Your transaction has been processed.", "success_notification");
						$this->get("routing")->redirect("make_transfer_get", array());
						return;
					}
				}
				else{
					$this->get("flash_bag")->add(_OPERATION_FAILURE, "Please enter the correct transaction code.", "error_notification");
					$this->get("routing")->redirect("make_transfer_get", array());
                    return;
				}
			}
		}
		// render the form
		$this->get("templating")->render("make_transfer.html.php", array(
			"form" => $helper
		));
	}
}