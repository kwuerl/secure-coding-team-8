<?php
namespace Controller;
/**
 * Employee Controller class that handles loading of user-related pages. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */

class EmployeeController extends Controller {

	public function loadOverview ($request) {
        // render the form
        $this->get("templating")->render("employee_overview.html.php", array(
            //"form" => $helper
        ));
	}
	public function loadProfile ($request) {
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in employee */
        /*Fetch the details of the current employee */
        $employee = $this->get('employee_repository')->get($currentUserId);
        $this->get("templating")->render("profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $employee
        ));
    }
    public function loadCustomersList ($request) {
        /*Fetch the details of all customers*/
        $customerList = $this->get('user_repository')->getAll();
        // render the form
        $this->get("templating")->render("customers_list.html.php", array(
            //"form" => $helper
            "customerList" => $customerList
        ));
    }
     public function loadCustomerDetails ($request, $customerId) {
        /*Fetch the details of the selected customer */
        $customer = $this->get('user_repository')->get($customerId);
        /*Fetch all transactions for the selected customer*/
        $transactionList = $this->get('transaction_repository')->getTransactionsByCustomerId($customerId);
        
        /*Separate the transactions into completed and on-hold transactions.*/
        $onHoldTransactionList = array();
        $approvedTransactionList = array();
        foreach ($transactionList as $transaction) {
            $onHold = $transaction->getOnHold();
            if ($onHold)
                $onHoldTransactionList[] = $transaction;
            else
                $approvedTransactionList[] = $transaction;
        }
        // render the form
        $this->get("templating")->render("customer_details.html.php", array(
            //"form" => $helper
            "customer" => $customer,
            "onHoldTransactionList" => $onHoldTransactionList,
            "approvedTransactionList" => $approvedTransactionList
        ));
    }
    public function approveRegistrations ($request) {
        // render the form
        $this->get("templating")->render("approve_registration.html.php", array(
            //"form" => $helper
        ));
    }
    public function approveTransactions ($request) {
        // render the form
        $this->get("templating")->render("approve_transactions.html.php", array(
            //"form" => $helper
        ));
    }
}