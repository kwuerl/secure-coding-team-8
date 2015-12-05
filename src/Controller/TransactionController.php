<?php
namespace Controller;

/**
 * Transaction Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia <vivek.sethia@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
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
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("to_account_name", "name", array(
			array("required", "Account Holder Name is required"),
			array("name", "Only letters, '-' and white space allowed and must be at least 2 characters")
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("amount", "text", array(
			array("required", "Amount to be transfered should be specified"),
			//array("name", "Max. 50000 per day allowed"),
			array("maxLength", "Enter 15 digit transaction code", array(15))
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("transaction_code", "text", array(
			array("required", "Transaction code is required"),
			array("maxLength", "Enter 15 digit transaction code", array(15))
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("remarks", "text", array(
			array("required", "Remarks is required"),
			array("maxLength", "Max. 100 characters allowed", array(100))
		), array("ltrim", "rtrim", "stripTags"), "");

		// process the request
		if ($helper->processRequest($request)) {
			return $this->processSingleTransfer($request, $helper, $customer);
		}

		// make transfer via file upload
		$helper2 = new \Helper\FormHelper("make_transfer_via_file_upload");

		$helper2->addField("file", "", array(
		), array("ltrim", "rtrim"), "");

		if ($helper2->processRequest($request)) {
			return $this->processBatchTransfer($request, $helper2, $customer);
		}

		// render the form
		$this->get("templating")->render("Customer/make_transfer.html.php", array(
			"form" => $helper,
			"form2" => $helper2,
		));
	}

	private function processSingleTransfer($request, $helper, $customer) {
		//try to validate
		if ($helper->validate()) {

			$requestVar = $request->getData('make_transfer');
			$transaction_code = $requestVar['transaction_code'];
			$amount = $requestVar['amount'];

			/*Return if the amount entered is invalid(i.e., negative or 0)*/
			if( $amount <= 0 ){
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect amount for the transfer.", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
				return;
			}

			$customer_id = $customer->getId();
			$account_repo = $this->get('account_repository');
			$transaction_code_repo = $this->get('transaction_code_repository');

			// fill the model
			$model = new \Model\Transaction();
			$helper->fillModel($model);

			$from_account = $account_repo->findOne(array("customer_id" => $customer_id));
			$to_account = $account_repo->findOne(array("account_id" => $model->getToAccountId()));
			$from_account_id = $from_account->getAccountId();
			$from_account_balance = $from_account->getBalance();

			/*Return if recipient account is same as own account.*/
			if ($model->getToAccountId() === $from_account_id) {
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "Recipient Account same as own account.", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
				return;
			}
			/*Return if recipient account does not exist*/
			if (!$to_account) {
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "Recipient Account does not exist.", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
				return;
			}
			/*Return if customer account does not have sufficient funds*/
			if ($amount > $from_account_balance) {
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "Insufficient funds for the transfer.", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
				return;
			}

			if ($customer->getTanMethod() === _TAN_METHOD_SCS) {
				//TODO
			} else {
				$is_valid_transaction_code = $transaction_code_repo->findOne(array("customer_id" => $customer_id, "code" => $transaction_code, "is_used" => 0));

				// Checking whether the transaction is valid , then proceed further
				if (!empty($is_valid_transaction_code)) {


					$model->setTransactionDate(date("Y-m-d H:i:s"));
					$model->setFromAccountId($from_account_id);

					/*Put the transaction on hold if the transfer amount > 10000.*/
					if ($amount > _TRANSFER_LIMIT_FOR_AUTO_APPROVAL ){
						$model->setIsOnHold(1);
					} else { /*Else, close the transaction by auto-approval.*/
						$model->setIsClosed(1);
					}

					// add to transaction repository
					if ($this->get('transaction_repository')->makeTransfer($model, $account_repo, $from_account, $to_account, $transaction_code_repo, $is_valid_transaction_code)) {
						// after successful transfer , redirect to make_transfer page
						$this->get("flash_bag")->add(_OPERATION_SUCCESS, "Your transaction has been processed.", "success_notification");
						$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
						return;
					}
				} else {
					$this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect TAN (transaction code).", "error");
					$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
					return;
				}
			}
		}
	}

	private function processBatchTransfer($request, $helper2, $customer) {
		if ($helper2->validate()) {
			$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/tmp/';
			$file = $request->getFile('make_transfer_via_file_upload', 'file');
			if ($file['type'] != "text/plain") {
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "The uploaded file must be a plain text file", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
				return;
			} else if ($file['error'] == 2) {
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "The uploaded file size exceeds the maximum of 1 MB", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
				return;
			}
			$random_file_name = str_replace("/", "", \Service\RandomSequenceGeneratorService::getString(10));
			$uploaded_file_name = $upload_dir.$random_file_name.".txt";

			// rename uploaded file name if already exists
			$i = 1;
			do {
				if ($i == 1) {
					$pos = strrpos($uploaded_file_name, ".txt");
					$uploaded_file_name = substr_replace($uploaded_file_name, "_".$i, $pos, 0);
				} else {
					$pos = strrpos($uploaded_file_name, "_".($i-1).".txt");
					$uploaded_file_name = substr_replace($uploaded_file_name, "_".$i, $pos, strlen((string)$i)+1);
				}
				$i++;
			} while (file_exists($uploaded_file_name));

			if ($file['tmp_name'] !== "" && move_uploaded_file($file['tmp_name'], $uploaded_file_name)) {
				// file was uploaded successfully
				$customer_id = $customer->getId();
				$customer_account_id = $this->get('account_repository')->findOne(array("customer_id" => $customer_id))->getAccountId();
				$shell_command = $_SERVER['DOCUMENT_ROOT'] .
					"/../textparser/textparser " .
					escapeshellarg($uploaded_file_name) . " " .
					escapeshellarg($customer_id) . " " .
					escapeshellarg($customer_account_id) . " " .
					escapeshellarg(_MYSQL_HOST) . " " .
					escapeshellarg(_MYSQL_USER) . " " .
					escapeshellarg(_MYSQL_PASSWORD) . " " .
					escapeshellarg(_MYSQL_DATABASE);
				exec($shell_command, $output, $return_var);
				if ($return_var == 0) {
					$this->get("flash_bag")->add(_OPERATION_SUCCESS, "Your transaction has been processed.", "success_notification");
				} else {
					if (in_array("Incorrect transaction code.", $output)) {
						$this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect transaction code(s).", "error");
					} else if (in_array("Error in connecting to the database.", $output)) {
						$this->get("flash_bag")->add(_OPERATION_FAILURE, "There was an error with connecting to the database. Please try again later.", "error");
					} else {
						$this->get("flash_bag")->add(_OPERATION_FAILURE, "There was an error with your transaction. Please try again later.", "error");
					}
				}
				unlink($uploaded_file_name);
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
				return;
			} else {
				$this->get("flash_bag")->add(_OPERATION_FAILURE, "There was an error with uploading the file. Please try again later.", "error");
				$this->get("routing")->redirect("make_transfer_get", array("form" => $helper));
				return;
			}
		}
	}
}