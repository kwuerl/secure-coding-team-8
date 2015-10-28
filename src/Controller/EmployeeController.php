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
        $customerList = $this->get('customer_repository')->find(array("is_active"=>1));
        $customerRegistrationList = $this->get('customer_repository')->find(array("is_active"=>0));

        // render the form
        $this->get("templating")->render("customers_list.html.php", array(
            //"form" => $helper
            "customerList" => $customerList,
            "customerRegistrationList" => $customerRegistrationList
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
            $onHold = $transaction->getIsOnHold();
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
    public function loadPendingTransactions ($request) {
        // create the FormHelper
        $helper = new \Helper\FormHelper("approve_transaction");
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch all transactions that are on-hold.*/
        $transactionList = $this->get('transaction_repository')->find(array("is_on_hold"=>1));
        // render the form
        $this->get("templating")->render("approve_transactions.html.php", array(
            "form" => $helper,
            "transactionList" => $transactionList
        ));
    }

    public function actOnTransactions ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*perform appropriate actions on the transaction based on the specified action.*/
        switch ($request->getData('action_transaction')) {
            case _ACTION_APPROVE_TRANSACTION:
                $error = $this->get('transaction_repository')->approveTransaction($request->getData('selectedTransactionId'));
                break;
            case _ACTION_REJECT_TRANSACTION:
                $error = $this->get('transaction_repository')->rejectTransaction($request->getData('selectedTransactionId'));
                break;
        }
        if (!$error) {
            $this->get("flash_bag")->add("Approval successful", "Transaction was approved successfully.", "success");
        } else {
            $this->get("flash_bag")->add("Operation failed!", $error, "error");
        }
        $this->get('routing')->redirect('transactions_get',array());
        return;
    }
}