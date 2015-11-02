<?php
namespace Controller;
/**
 * Customer Controller class that handles loading of customer-related pages. Gets ServiceContainer injected
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

class CustomerController extends UserController {

	public function loadOverview ($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        $customer_id = $customer->getId();
        /*Fetch the details of the current user */
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customer_id));
        // loads customer transactions
        $transactionList = $this->get('transaction_repository')->getAllByCustomerId($customer_id, _TRANSACTIONS_PER_PAGE);

        // render the form
        $this->get("templating")->render("Customer/account_overview.html.php", array(
            //"form" => $helper
            "accountInfo" => $accountInfo,
            "transactionList" => $transactionList
        ));
	}
	public function loadProfile ($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        // render the form
        $this->get("templating")->render("Customer/customer_profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $customer
        ));
    }
    public function loadTransactionHistory ($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        $helper = new \Helper\FormHelper("download_pdf_form");
        $customer_id = $customer->getId();
        /*Fetch the details of the current user */
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customer_id));
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getByCustomerId($customer_id);
        // render the form
        $this->get("templating")->render("Customer/transaction_history.html.php", array(
            "form" => $helper,
            "transactionList" => $transactionList,
            "accountInfo" => $accountInfo
        ));
    }

    public function generateStatementPDF($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        $customer_id = $customer->getId();
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getAllByCustomerId($customer_id);
        // Fetch the account details for current user
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customer_id));

        // render the form
        $this->get("templating")->render("transaction_history_download.php", array(
            //"form" => $helper
            "transactionList" => $transactionList,
            "accountInfo" => $accountInfo,
            "customer" => $customer,
            "invokedFrom" => _STATEMENT,
        ));
    }

    public function generateTransactionHistoryPDF($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        $customer_id = $customer->getId();
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getByCustomerId($customer_id);
        // Fetch the account details for current user
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customer_id));

        // render the form
        $this->get("templating")->render("transaction_history_download.php", array(
            //"form" => $helper
            "transactionList" => $transactionList,
            "accountInfo" => $accountInfo,
            "customer" => $customer,
            "invokedFrom" => _TRANSACTION_HISTORY
        ));
    }


    public function loadStatement($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        $helper = new \Helper\FormHelper("download_pdf_form");
        $customer_id = $customer->getId();
        /*Fetch the details of the current user */
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customer_id));
        // loads customer transactions
        $transactionList = $this->get('transaction_repository')->getAllByCustomerId($customer_id);

        // render the form
        $this->get("templating")->render("Customer/statement.html.php", array(
            "form" => $helper,
            "accountInfo" => $accountInfo,
            "transactionList" => $transactionList,
            "invokedFrom" => _STATEMENT,
        ));
    }
}