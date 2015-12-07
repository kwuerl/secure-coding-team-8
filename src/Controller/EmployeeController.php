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
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        
        $customer_repo = $this->get('customer_repository');
        $transaction_repo = $this->get('transaction_repository');

        /*Fetch the details of all customers*/
        $customerList = $customer_repo->find(array("is_active"=>1));
        $customerRegistrationList = $customer_repo->find(array("is_active"=>0, "is_rejected"=>0));

        $pendingTransactions = $transaction_repo->find(array("is_on_hold"=>1));

        $customerRegistrationsToday = $customer_repo->find(array("registration_date" => date("Y-m-d") . "%"));
        $transactionsToday = $transaction_repo->find(array("transaction_date" => date("Y-m-d") . "%"));

        $latestTransactionList = $transaction_repo->find(array("is_on_hold" => 0, "is_rejected" => 0), array("transaction_date" => "DESC"));

        // render the form
        $this->get("templating")->render("Employee/employee_overview.html.php", array(
            "customerCount" => count($customerList),
            "pendingCustomerCount" => count($customerRegistrationList),
            "pendingTransactionsCount" =>  count($pendingTransactions),
            "registrationsTodayCount" => count($customerRegistrationsToday),
            "transactionsTodayCount" => count($transactionsToday),
            "latestTransactionList" => $latestTransactionList,
            "currentUser" => $employee
        ));
	}
	public function loadProfile ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        // render the form
        $this->get("templating")->render("Employee/employee_profile_view.html.php", array(
            //"form" => $helper,
        ));
    }

    private function getEmployeeRegistrationFormHelper () {
        $helper =  $this->get("form")->getCSRFFormHelper("action_employee_registration");

        $helper->addField("employee_id", "text", array(
            array("required", "employee_id is required"),
            array("number", "Only numbers are allowed"),
        ), array("ltrim", "rtrim", "stripTags"), "");

        return $helper;
    }

    public function loadEmployeesList ($request) {
        $employee = $this->get("auth")->check(_GROUP_ADMIN);
        $helper = $this->getEmployeeRegistrationFormHelper();
        /*Fetch the details of all employees*/
        $employeeList = $this->get('employee_repository')->find(array("is_active"=>1));
        /*Fetch all transactions for the selected customer*/
        $employeeRegistrationList = $this->get('employee_repository')->find(array("is_active"=>0, "is_rejected"=>0));
        // render the form
        $this->get("templating")->render("Employee/employees_list.html.php", array(
            "form" => $helper,
            "employeeRegistrationList" => $employeeRegistrationList,
            "employeeList" => $employeeList
        ));
    }

    public function rejectEmployee ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $helper = $this->getEmployeeRegistrationFormHelper();
        if ($helper->processRequest($request)) {
            if ($helper->validate()) {
                $user_id = $helper->getValue("employee_id");
                $user_model = $this->get('employee_repository')->findOne(array("id" => $user_id));
                if($user_model != false) {
                    if($this->get('employee_repository')->actOnRegistration($user_model, _ACTION_REJECT) != false) {
                        $this->get("flash_bag")->add(_OPERATION_SUCCESS, "Employee registration was rejected successfully.", "success_notification");
                        return $this->get('routing')->redirect('transactions_get',array());
                    }
                }
            }
        }
        $this->get("flash_bag")->add(_OPERATION_FAILURE, "The Employee registration could not be rejected", "error");
        return $this->get('routing')->redirect('transactions_get',array());
    }

    public function approveEmployee ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $helper = $this->getEmployeeRegistrationFormHelper();
        if ($helper->processRequest($request)) {
            if ($helper->validate()) {
                $user_id = $helper->getValue("employee_id");
                $user_model = $this->get('employee_repository')->findOne(array("id" => $user_id));
                if($user_model != false) {
                    if($this->get('employee_repository')->actOnRegistration($user_model, _ACTION_APPROVE) != false) {
                        $this->get("flash_bag")->add(_OPERATION_SUCCESS, "Employee registration was approved successfully.", "success_notification");
                        return $this->get('routing')->redirect('transactions_get',array());
                    }
                }
            }
        }
        $this->get("flash_bag")->add(_OPERATION_FAILURE, "The Employee registration could not be approved", "error");
        return $this->get('routing')->redirect('transactions_get',array());
        
    }

    

    public function generatePendingTransactionsPDF($request) {
            $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
            /*Fetch the transaction details for the corresponding customer */
            $transactionList = $this->get('transaction_repository')->find(array("is_on_hold"=>1));

            // render the form
            $this->get("templating")->render("transaction_history_download.php", array(
                //"form" => $helper
                "transactionList" => $transactionList,
                "invokedFrom" => _PENDING_TRANSACTIONS,
            ));
        }

    public function generateCompletedTransactionsPDF($request){
			$employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
            /*Fetch the transaction details for the corresponding customer */
            $transactionList = $this->get('transaction_repository')->find(array("is_on_hold"=>0));

            // render the form
            $this->get("templating")->render("transaction_history_download.php", array(
                //"form" => $helper
                "transactionList" => $transactionList,
                "invokedFrom" => _COMPLETED_TRANSACTIONS,
            ));
	}

}