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
        $helper = new \Helper\FormHelper("action_registration_form");
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch the details of all customers*/
        $customerList = $this->get('customer_repository')->find(array("is_active"=>1));
        $customerRegistrationList = $this->get('customer_repository')->find(array("is_active"=>0, "is_rejected"=>0));

        // render the form
        $this->get("templating")->render("customers_list.html.php", array(
            "form" => $helper,
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
            "customer" => $customer,
            "onHoldTransactionList" => $onHoldTransactionList,
            "approvedTransactionList" => $approvedTransactionList
        ));
    }
    public function loadEmployeesList ($request) {
        $helper = new \Helper\FormHelper("action_registration_form");
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch the details of all employees*/
        $employeeList = $this->get('employee_repository')->find(array("is_active"=>1));
        /*Fetch all transactions for the selected customer*/
        $employeeRegistrationList = $this->get('employee_repository')->find(array("is_active"=>0, "is_rejected"=>0));
        // render the form
        $this->get("templating")->render("employees_list.html.php", array(
            "form" => $helper,
            "employeeRegistrationList" => $employeeRegistrationList,
            "employeeList" => $employeeList
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
        $transactionId = $request->getData('selectedTransactionId');
        $action = $request->getData('action_transaction');

        /*perform appropriate actions on the transaction based on the specified action.*/
        switch ($action) {
            case _ACTION_APPROVE:
                $error = $this->get('transaction_repository')->actOnTransaction($transactionId, $action);
                $success = 'Transaction was approved successfully.';
                break;
            case _ACTION_REJECT:
                $error = $this->get('transaction_repository')->actOnTransaction($transactionId, $action);
                $success = 'Transaction was rejected successfully.';
                break;
        }
        $this->notify($success, $error);
        $this->get('routing')->redirect('transactions_get',array());
    }

    public function actOnEmployeeRegistrations ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $action = $request->getData('action_registration');
        $user_id = $request->getData('selectedUserId');

        switch ($action) {
            case _ACTION_APPROVE:
                $error = $this->get('employee_repository')->actOnRegistration($user_id, $action);
                $success = 'Employee registration was approved successfully.';
                break;
            case _ACTION_REJECT:
                $error = $this->get('employee_repository')->actOnRegistration($user_id, $action);
                $success = 'Employee registration was rejected successfully.';
                break;
        }
        $this->notify($success, $error);
        $this->get('routing')->redirect('employees_get',array());
    }

    public function actOnCustomerRegistrations ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $action = $request->getData('action_registration');
        $user_id = $request->getData('selectedUserId');
        $user_model = $this->get('customer_repository')->findOne(array("id" => $user_id));

        switch ($action) {
            case _ACTION_APPROVE:
                $error = $this->get('customer_repository')->actOnRegistration($user_id, $action);
                $success = 'Customer registration was approved successfully.';
                // send email with transaction codes
                $tans = $this->get("transaction")->generateTransactionCodeSet($user_id);
                $email_msg = $this->get("templating")->render(
                    "email_transaction_codes.html.php",
                    array(
                        "tans" => $tans,
                        "user" => $user_model
                    ),
                    false);
                $this->get("email")->sendMail(
                    $user_model->getEmail(),
                    "Your registration at SecureBank was successful!",
                    $email_msg
                );
                break;
            case _ACTION_REJECT:
                $error = $this->get('customer_repository')->actOnRegistration($user_id, $action);
                $success = 'Customer registration was rejected successfully.';
                break;
        }
        $this->notify($success, $error);
        $this->get('routing')->redirect('customers_get',array());
    }
    private function notify($success, $error) {
        if (!$error) {
            $this->get("flash_bag")->add(_OPERATION_SUCCESS, $success, "success");
        } else {
            $this->get("flash_bag")->add(_OPERATION_FAILURE, $error, "error");
        }
    }
}