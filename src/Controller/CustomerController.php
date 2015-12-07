<?php
namespace Controller;

use \Exception\RegistrationIsClosedException;
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

    public function downloadSCS($request){
        $customer = $this->get("auth")->check(_GROUP_USER);
        /*Send the file to the browser as a download*/
        header('Content-disposition: attachment; filename=SecureBank-SCS.zip');
        header('Content-type: application/zip');
        readfile("../downloads/SecureBank-SCS.zip");
    }


    // -----------------   EMPLOYEE USER NEEDED --------------------------

    public function loadCustomerDetails ($request, $customerId) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        /*Fetch the details of the selected customer */
        $customer = $this->get('customer_repository')->get($customerId);
        /*Fetch the details of the current user */
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>(int)$customerId));
        /*Fetch all transactions for the selected customer*/
        $result = $this->get("transaction_repository")->getUserTransactionsCategorized($customerId);
        // render the form
        $this->get("templating")->render("Employee/customer_details.html.php", array(
            "customer" => $customer,
            "accountInfo" => $accountInfo,
            "onHoldTransactionList" => $result['onHoldTransactionList'],
            "approvedTransactionList" => $result['approvedTransactionList']
        ));
    }
     
    private function getCustomerRegistrationFormHelper () {
        $helper =  $this->get("form")->getCSRFFormHelper("action_customer_registration");

        $helper->addField("customer_id", "text", array(
            array("required", "employee_id is required"),
            array("number", "Only numbers are allowed"),
        ), array("ltrim", "rtrim", "stripTags"), "");

        return $helper;
    }

    private function getSetBalanceFormHelper () {
        $helper =  $this->get("form")->getCSRFFormHelper("action_customer_balance");

        $helper->addField("customer_id", "text", array(
            array("required", "employee_id is required"),
            array("number", "Only numbers are allowed"),
        ), array("ltrim", "rtrim", "stripTags"), "");

        $helper->addField("balance", "text", array(
            array("required", "employee_id is required"),
            array("number", "Only numbers are allowed"),
        ), array("ltrim", "rtrim", "stripTags"), "");

        return $helper;
    }

    public function loadCustomersList ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $helper =  $this->getCustomerRegistrationFormHelper();
        $helper_balance =  $this->getSetBalanceFormHelper();
        /*Fetch the details of all customers*/
        $customerList = $this->get('customer_repository')->find(array("is_active"=>1));
        $customerRegistrationList = $this->get('customer_repository')->find(array("is_active"=>0, "is_rejected"=>0));

        // render the form
        $this->get("templating")->render("Employee/customers_list.html.php", array(
            "form" => $helper,
            "balance_form" => $helper_balance,
            "customerList" => $customerList,
            "customerRegistrationList" => $customerRegistrationList
        ));
    }

    public function rejectCustomer ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $helper = $this->getCustomerRegistrationFormHelper();
        if ($helper->processRequest($request)) {
            if ($helper->validate()) {
                $user_id = $helper->getValue("customer_id");
                $user_model = $this->get('customer_repository')->findOne(array("id" => $user_id));
                if($user_model != false) {
                    if($this->get('customer_repository')->actOnRegistration($user_model, _ACTION_REJECT) != false) {
                        $this->get("flash_bag")->add(_OPERATION_SUCCESS, "Customer registration was rejected successfully.", "success_notification");
                        return $this->get('routing')->redirect('customers_get',array());
                    }
                }
            }
        }
        $this->get("flash_bag")->add(_OPERATION_FAILURE, "The Customer registration could not be rejected", "error");
        return $this->get('routing')->redirect('customers_get',array());
    }

    public function approveCustomer ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $helper = $this->getCustomerRegistrationFormHelper();
        if ($helper->processRequest($request)) {
            if ($helper->validate()) {
                $user_id = $helper->getValue("customer_id");
                $user_model = $this->get('customer_repository')->findOne(array("id" => $user_id));
                if($user_model != false) {
                    try {
                        $this->get('customer')->initialize($user_model);
                        $this->get("flash_bag")->add(_OPERATION_SUCCESS, "Customer registration was accepted successfully.", "success_notification");
                        return $this->get('routing')->redirect('customers_get',array());
                    } catch (Excpetion $e) {

                    }
                }
            }
        }
        $this->get("flash_bag")->add(_OPERATION_FAILURE, "The Customer registration could not be approved", "error");
        return $this->get('routing')->redirect('customers_get',array());
        
    }

    public function setBalance ($request) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $helper =  $this->getSetBalanceFormHelper();
        if ($helper->processRequest($request)) {
            if ($helper->validate()) {
                $user_id = $helper->getValue("customer_id");
                $user_model = $this->get('customer_repository')->findOne(array("id" => $user_id));
                if($user_model != false) {
                    $balance = $helper->getValue("balance");
                    $account_repo = $this->get('account_repository');
                    $account_model = $account_repo->findOne(array("customer_id"=>$user_id));
                    if(is_numeric($balance) && $balance <= _MAX_ALLOWED_BALANCE_INITIALIZATION) {
                         /*Check if balance is not already initialized.*/
                        if (!$user_model->getIsAccountBalanceInitialized()) {
                            $account_model->setBalance($balance);

                            $result = $account_repo->update($account_model, array("balance"), array("customer_id"=>$user_id));
                            if ($result) {
                                $user_model->setIsAccountBalanceInitialized(1);
                                $result = $this->get('customer_repository')->update($user_model, array("is_account_balance_initialized"), array("id"=>$user_id));
                                if ($result) {
                                    $this->get("flash_bag")->add(_OPERATION_SUCCESS, "Account Balance initialized successfully.", "success_notification");
                                    return $this->get('routing')->redirect('customers_get',array());
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->get("flash_bag")->add(_OPERATION_FAILURE, "Account Balance initialisation failed", "error");
        return $this->get('routing')->redirect('customers_get',array());
    }

    public function generateCustomerPendingTransactionPDF($request, $customerId) {
        $employee = $this->get("auth")->check(_GROUP_EMPLOYEE);
        $customer = $this->get('customer_repository')->get($customerId);
        // Fetch the account details for corresponding customer
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>(int)$customerId));
        /*Fetch the transaction details for the corresponding customer */
        $transactions = $this->get("transaction_repository")->getUserTransactionsCategorized((int)$customerId);
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
        $accountInfo = $this->get('account_repository')->findOne(array("customer_id"=>(int)$customerId));
        /*Fetch the transaction details for the corresponding customer */
        $transactions = $this->get("transaction_repository")->getUserTransactionsCategorized((int)$customerId);
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

}