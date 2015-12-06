<?php
namespace Controller;

/**
 * Transaction Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia <vivek.sethia@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class TransactionController extends Controller {

	public function makeTransfer($request) {
		$customer = $this->get("auth")->check(_GROUP_USER);

		// create the FormHelper
        $helper = new \Helper\FormHelper("make_transfer");

        // make transfer via file upload
        $helper2 = new \Helper\FormHelper("make_transfer_via_file_upload");

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
			//try to validate
			if ($helper->validate()) {
				return $this->processSingleTransfer($request, $helper, $helper2, $customer);
			}
		}

	    $helper2->addField("transaction_code", "text", array(
            array("required", "Transaction code is required"),
            array("maxLength", "Enter 15 digit transaction code", array(15))
        ), array("ltrim", "rtrim", "stripTags"), "");

		$helper2->addField("file", "", array(
		), array("ltrim", "rtrim"), "");

		if ($helper2->processRequest($request)) {
			//try to validate
			if ($helper2->validate()) {
				return $this->processBatchTransfer($request, $helper, $helper2, $customer);
			}
		}
		// render the form
		$this->get("templating")->render("Customer/make_transfer.html.php", array(
			"form" => $helper,
			"form2" => $helper2,
		));
	}

	private function processSingleTransfer($request, $helper, $helper2, $customer) {
        $requestVar = $request->getData('make_transfer');
        $transaction_code = $requestVar['transaction_code'];
        $amount = $requestVar['amount'];

        /*Return if the amount entered is invalid(i.e., negative or 0)*/
        if( $amount <= 0 ){
            $this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect amount for the transfer.", "error");
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }

        $customer_id = $customer->getId();
        $customer_name = $customer->getFirstName() . " " . $customer->getLastName();
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
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }
        /*Return if recipient account does not exist*/
        if (!$to_account) {
            $this->get("flash_bag")->add(_OPERATION_FAILURE, "Recipient Account does not exist.", "error");
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }
        /*Return if customer account does not have sufficient funds*/
        if ($amount > $from_account_balance) {
            $this->get("flash_bag")->add(_OPERATION_FAILURE, "Insufficient funds for the transfer.", "error");
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }

        /*Check if SCS is enabled for the customer*/
        if ((int)$customer->getTanMethod() === _TAN_METHOD_SCS) {
            $scs_pin = $this->get("scs")->getPin($customer_id);

            /*Generate the TAN for the transaction based on the entered details and the customer's SCS pin*/
            $scs_transaction_code = $this->get("scs")->generateTan($model->getToAccountId(), $model->getAmount(), $scs_pin);
            $is_valid_transaction_code = ($scs_transaction_code === $transaction_code) ? $transaction_code : false;

            /*Return if the SCS pin or transaction code is invalid*/
            if (!$is_valid_transaction_code) {
                $this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect SCS pin or TAN (transaction code).", "error");
                $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
                return;
            }

            $code_exists = $this->get("transaction_code")->isCodeExists($transaction_code);

            /*Return if the transaction code is already used*/
            if ($code_exists) {
                $this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect TAN (transaction code).", "error");
                $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
                return;
            }
        } else {
            $is_valid_transaction_code = $this->get("transaction_code")->isCodePristine($customer_id, $transaction_code);

            /*Return if the transaction code is invalid*/
            if (!$is_valid_transaction_code) {
                $this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect TAN (transaction code).", "error");
                $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
                return;
            }
        }
        $model->setTransactionDate(date("Y-m-d H:i:s"));
        $model->setFromAccountId($from_account_id);
        $model->setFromAccountName($customer_name);

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
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }
	}

	private function processBatchTransfer($request, $helper, $helper2, $customer) {
	    $requestVar = $request->getData('make_transfer_via_file_upload');
        $transaction_code = $requestVar['transaction_code'];

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

        $customer_id = $customer->getId();
        $customer_name = $customer->getFirstName() . " " . $customer->getLastName();
        $is_valid_transaction_code = $this->get("transaction_code")->isCodePristine($customer_id, $transaction_code);

        /*Return if the TAN code is invalid*/
        if (!$is_valid_transaction_code) {
            $this->get("flash_bag")->add(_OPERATION_FAILURE, "Incorrect TAN (transaction code).", "error");
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }

        $random_file_name = str_replace("/", "", $this->get("random")->getString(10));
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

        /*Check if the file was uploaded successfully*/
        if ($file['tmp_name'] !== "" && move_uploaded_file($file['tmp_name'], $uploaded_file_name)) {
            $customer_account_id = $this->get('account_repository')->findOne(array("customer_id" => $customer_id))->getAccountId();

            $shell_command = $_SERVER['DOCUMENT_ROOT'] .
                "/../textparser/textparser " .
                escapeshellarg($uploaded_file_name) . " " .
                escapeshellarg($customer_id) . " " .
                escapeshellarg($customer_name) . " " .
                escapeshellarg($customer_account_id) . " " .
                escapeshellarg($transaction_code) . " " .
                escapeshellarg(_MYSQL_HOST) . " " .
                escapeshellarg(_MYSQL_USER) . " " .
                escapeshellarg(_MYSQL_PASSWORD) . " " .
                escapeshellarg(_MYSQL_DATABASE);
            exec($shell_command, $output, $return_var);
            if ($return_var == 0) {
                $this->get("flash_bag")->add(_OPERATION_SUCCESS, "Your transaction has been processed.", "success_notification");
            } else {
                $this->get("flash_bag")->add(_OPERATION_FAILURE, $output[0], "error");
            }
            unlink($uploaded_file_name);
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        } else {
            $this->get("flash_bag")->add(_OPERATION_FAILURE, "There was an error with uploading the file. Please try again later.", "error");
            $this->get("routing")->redirect("make_transfer_get", array("form" => $helper, "form2" => $helper2));
            return;
        }
    }
}