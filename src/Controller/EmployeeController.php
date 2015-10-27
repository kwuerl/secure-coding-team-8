<?php
namespace Controller;
/**
 * Employee Controller class that handles loading of employee-related pages. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

class EmployeeController extends UserController {

	public function loadOverview ($request) {
        $this->get("auth")->check(_GROUP_EMPLOYEE);
        // render the form
        $this->get("templating")->render("employee_overview.html.php", array(
            //"form" => $helper
        ));
	}
	public function loadProfile ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        // render the form
        $this->get("templating")->render("employee_profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $employee
        ));
    }
    public function loadCustomersList ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch the details of all customers*/
        $customerList = $this->get('customer_repository')->getAll();
        // render the form
        $this->get("templating")->render("customers_list.html.php", array(
            //"form" => $helper
            "customerList" => $customerList
        ));
    }
     public function loadCustomerDetails ($request, $customerId) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch the details of the selected customer */
        $customer = $this->get('customer_repository')->get($customerId);
        /*Fetch all transactions for the selected customer*/
        $transactionList = $this->get('transaction_repository')->getByCustomerId($customerId);
        
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
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch all transactions for the selected customer*/
        $customerRegistrationList = $this->get('customer_repository')->find(array("is_active"=>0));
        $employeeRegistrationList = $this->get('employee_repository')->find(array("is_active"=>0));
        // render the form
        $this->get("templating")->render("approve_registration.html.php", array(
            //"form" => $helper
            "customerRegistrationList" => $customerRegistrationList,
            "employeeRegistrationList" => $employeeRegistrationList
        ));
    }
    public function approveTransactions ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch all transactions that are on-hold.*/
        $transactionList = $this->get('transaction_repository')->find(array("is_on_hold"=>1));
        // render the form
        $this->get("templating")->render("approve_transactions.html.php", array(
            //"form" => $helper
            "transactionList" => $transactionList
        ));
    }
}