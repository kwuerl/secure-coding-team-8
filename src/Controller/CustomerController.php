<?php
namespace Controller;
/**
 * Customer Controller class that handles loading of customer-related pages. Gets ServiceContainer injected
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

class CustomerController extends UserController {

	public function loadOverview ($request) {
        // render the form
        $this->get("templating")->render("account_overview.html.php", array(
            //"form" => $helper
        ));
	}
	public function loadProfile ($request) {
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in user */
        /*Fetch the details of the current user */
        $customer = $this->get('customer_repository')->get($currentUserId);
        // render the form
        $this->get("templating")->render("profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $customer
        ));
    }
    public function loadTransactionHistory ($request) {
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in user */
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getTransactionsByCustomerId($currentUserId);
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
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in user */
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getTransactionsByCustomerId($currentUserId);
        // render the form
        $this->get("templating")->render("transaction_history_download.php", array(
        //"form" => $helper
        "transactionList" => $transactionList
        ));
    }
}