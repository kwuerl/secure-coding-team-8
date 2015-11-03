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
    public function loadCustomersList ($request) {
        $helper = new \Helper\FormHelper("action_registration_form");
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch the details of all customers*/
        $customerList = $this->get('customer_repository')->find(array("is_active"=>1));
        $customerRegistrationList = $this->get('customer_repository')->find(array("is_active"=>0, "is_rejected"=>0));

        // render the form
        $this->get("templating")->render("Employee/customers_list.html.php", array(
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
        $result = $this->getTransactions($customerId);
        // render the form
        $this->get("templating")->render("Employee/customer_details.html.php", array(
            "customer" => $customer,
            "onHoldTransactionList" => $result['onHoldTransactionList'],
            "approvedTransactionList" => $result['approvedTransactionList']
        ));
    }
    public function loadEmployeesList ($request) {
        $helper = new \Helper\FormHelper("action_registration_form");
        $employee = $this->get("auth")->check(_GROUP_ADMIN);
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
    public function loadPendingTransactions ($request) {
        // create the FormHelper
        $helper = new \Helper\FormHelper("approve_transaction");
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch all transactions that are on-hold.*/
        $transactionList = $this->get('transaction_repository')->find(array("is_on_hold"=>1));
        // render the form
        $this->get("templating")->render("Employee/approve_transactions.html.php", array(
            "form" => $helper,
            "transactionList" => $transactionList
        ));
    }

    public function actOnTransactions ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $action = $request->getData('action_transaction');
        $transaction_id = $request->getData('selectedTransactionId');
        $transaction_model = $this->get('transaction_repository')->findOne(array("id" => (int)$transaction_id));

        /*perform appropriate actions on the transaction based on the specified action.*/
        switch ($action) {
            case _ACTION_APPROVE:
                /*Fetch the account details from the transaction*/
                $account_repo = $this->get('account_repository');
                $from_account_id = $transaction_model->getFromAccountId();
                $to_account_id = $transaction_model->getToAccountId();
                $from_account = $account_repo->findOne(array("account_id"=>$from_account_id));
                $to_account = $account_repo->findOne(array("account_id"=>$to_account_id));

                $error = $this->get('transaction_repository')->actOnTransaction($transaction_model, $action, $account_repo, $from_account, $to_account);
                $success = 'Transaction was approved successfully.';
                break;
            case _ACTION_REJECT:
                $error = $this->get('transaction_repository')->actOnTransaction($transaction_model, $action);
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
        $user_model = $this->get('employee_repository')->findOne(array("id" => $user_id));

        switch ($action) {
            case _ACTION_APPROVE:
                $error = $this->get('employee_repository')->actOnRegistration($user_model, $action);
                $success = 'Employee registration was approved successfully.';
                break;
            case _ACTION_REJECT:
                $error = $this->get('employee_repository')->actOnRegistration($user_model, $action);
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

                $helper = new \Helper\FormHelper("form_account");
                $account_repo = $this->get('account_repository');

                // fill the model
                $account_model = new \Model\Account();
                $helper->fillModel($account_model);
                $account_id = $this->get("account")->generateAccount($user_id);

                $account_model->setAccountId($account_id);
                $account_model->setCustomerId($user_id);
                $account_model->setType("SAVINGS");
                $account_model->setIsActive(1);
                $account_model->setBalance(10000);

                $error = $this->get('customer_repository')->actOnRegistration($user_model, $action, $account_repo, $account_model);
                $success = 'Customer registration was approved successfully.';
                if (!$error) {
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
                }
                break;
            case _ACTION_REJECT:
                $error = $this->get('customer_repository')->actOnRegistration($user_model, $action);
                $success = 'Customer registration was rejected successfully.';
                break;
        }
        $this->notify($success, $error);
        $this->get('routing')->redirect('customers_get',array());
    }

    public function generateCustomerPendingTransactionPDF($request, $customerId) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $customer = $this->get('customer_repository')->get($customerId);
        // Fetch the account details for corresponding customer
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customerId));
        /*Fetch the transaction details for the corresponding customer */
        $transactions = $this->getTransactions($customerId);
        // render the form
        $this->get("templating")->render("transaction_history_download.php", array(
            //"form" => $helper
            "accountInfo" => $accountInfo,
            "customer" => $customer,
            "invokedFrom" => _CUSTOMER_DETAILS_PENDING_TRANSACTION,
            "onHoldTransactionList" => $transactions['onHoldTransactionList'],
        ));
    }

     public function generateCustomerCompletedTransactionPDF($request, $customerId) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $customer = $this->get('customer_repository')->get($customerId);
       // Fetch the account details for corresponding customer
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>$customerId));
        /*Fetch the transaction details for the corresponding customer */
        $transactions = $this->getTransactions($customerId);
        // render the form
        $this->get("templating")->render("transaction_history_download.php", array(
            //"form" => $helper
            "transactionList" => $transactionList,
            "accountInfo" => $accountInfo,
            "customer" => $customer,
            "invokedFrom" => _CUSTOMER_DETAILS_COMPLETED_TRANSACTION,
            "approvedTransactionList" => $transactions['approvedTransactionList'],
        ));
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

    private function notify($success, $error) {
        if (!$error) {
            $this->get("flash_bag")->add(_OPERATION_SUCCESS, $success, "success_notification");
        } else {
            $this->get("flash_bag")->add(_OPERATION_FAILURE, $error, "error");
        }
    }

    private function getTransactions($customerId){
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
        return array(
            'onHoldTransactionList' => $onHoldTransactionList,
            'approvedTransactionList' => $approvedTransactionList
            );
    }

}