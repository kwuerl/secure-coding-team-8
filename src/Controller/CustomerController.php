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
        /*Fetch the details of the current user */
        $accountInfo = $this->get('account_repository')->find(array("customer_id"=>$customer->getId()));
        // render the form
        $this->get("templating")->render("account_overview.html.php", array(
            //"form" => $helper
            "currentUser" => $customer,
            "accountInfo" => $accountInfo
        ));
	}
	public function loadProfile ($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        // render the form
        $this->get("templating")->render("profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $customer
        ));
    }
    public function loadTransactionHistory ($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getByCustomerId($customer->getId());
        // render the form
        $this->get("templating")->render("transaction_history.html.php", array(
            //"form" => $helper,
            "transactionList" => $transactionList
        ));
    }
    public function makeTransfer ($request) {
        // render the form
        $this->get("templating")->render("make_transfer.html.php", array(
            //"form" => $helper
        ));
    }

    public function generateTransactionPDF($request) {
        $customer = $this->get("auth")->check(_GROUP_USER);
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getByCustomerId($customer->getId());
        // render the form
        $this->get("templating")->render("transaction_history_download.php", array(
        //"form" => $helper
        "transactionList" => $transactionList
        ));
    }
}