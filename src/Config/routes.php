<?php
/**
 *	$routing_service is instance of Service\RoutingService
 */
$routing_service->get("default", "/", "default_controller:landingFunction");

$routing_service->get("test_route", "/test/(:all)/(:all)/(:any)", "example_controller:testFunction");
$routing_service->get("form_example_get", "/form_example", "example_controller:formtest");
$routing_service->post("form_example_post", "/form_example", "example_controller:formtest");
$routing_service->get("test_transaction_codes", "/transaction_codes", "example_controller:testTransactionCode");
$routing_service->get("test_email_template", "/email_template", "example_controller:testEmailTemplate");
/*
 * Login and registration routes
 */
$routing_service->get("login_get", "/login", "login_controller:processLogin");
$routing_service->post("login_post", "/login", "login_controller:processLogin");
$routing_service->get("logout_get", "/logout", "login_controller:logout");
$routing_service->get("register_get", "/register", "registration_controller:processRegistration");
$routing_service->post("register_post", "/register", "registration_controller:processRegistration");
$routing_service->get("register_employee_get", "/register_employee", "registration_controller:processEmployeeRegistration");
$routing_service->post("register_employee_post", "/register_employee", "registration_controller:processEmployeeRegistration");

/*
 * Password recovery routes
 */
$routing_service->get("recover_password_get", "/recover_password", "login_controller:resetPassword");
$routing_service->post("recover_password_post", "/recover_password", "login_controller:resetPassword");
$routing_service->get("reset_password_get", "/reset_password", "login_controller:getPasswordResetView");
$routing_service->post("reset_password_post", "/reset_password", "login_controller:processPasswordReset");

/*
 * Customer routes
 */
$routing_service->get("overview", "/overview", "customer_controller:loadOverview");
$routing_service->get("profile", "/profile", "customer_controller:loadProfile");
$routing_service->get("transaction_history", "/transaction_history", "customer_controller:loadTransactionHistory");
$routing_service->get("make_transfer_get", "/make_transfer", "transaction_controller:makeTransfer");
$routing_service->post("make_transfer_form_post", "/make_transfer/form", "transaction_controller:makeTransferForm");
$routing_service->post("make_transfer_file_post", "/make_transfer/file", "transaction_controller:makeTransferFile");
$routing_service->post("statement_download", "/statement_download", "customer_controller:generateStatementPDF");
$routing_service->post("transaction_history_download", "/transaction_history_download", "customer_controller:generateTransactionHistoryPDF");
$routing_service->get("statement", "/statement", "customer_controller:loadStatement");
$routing_service->get("downloadscs", "/downloadscs", "customer_controller:downloadSCS");
$routing_service->get("customer_pending_transaction_download", "/customer_pending_transaction_download/(:num)",
                        "customer_controller:generateCustomerPendingTransactionPDF");
$routing_service->get("customer_completed_transaction_download", "/customer_completed_transaction_download/(:num)",
                        "customer_controller:generateCustomerCompletedTransactionPDF");

/*
 * Employee routes
 */
$routing_service->get("employee_overview", "/employee_overview", "employee_controller:loadOverview");
$routing_service->get("employee_profile", "/employee_profile", "employee_controller:loadProfile");
$routing_service->get("customers_get", "/customers", "customer_controller:loadCustomersList");
$routing_service->post("customers_accept_post", "/customers/approve","customer_controller:approveCustomer");
$routing_service->post("customers_reject_post", "/customers/reject","customer_controller:rejectCustomer");
$routing_service->post("customers_balance_post", "/customers/balance","customer_controller:setBalance");
$routing_service->get("customer_detail", "/customer_details/(:num)", "customer_controller:loadCustomerDetails");
$routing_service->get("employees_get", "/employees","employee_controller:loadEmployeesList");
$routing_service->post("employees_accept_post", "/employees/approve","employee_controller:approveEmployee");
$routing_service->post("employees_reject_post", "/employees/reject","employee_controller:rejectEmployee");
$routing_service->get("transactions_get", "/transactions","transaction_controller:loadPendingTransactions");
$routing_service->post("transactions_approve_post", "/transactions/approve","transaction_controller:approveTransaction");
$routing_service->post("transactions_reject_post", "/transactions/reject","transaction_controller:rejectTransaction");
$routing_service->get("transactions_pending_download", "/transactions_pending_download",
                        "employee_controller:generatePendingTransactionsPDF");
$routing_service->get("transactions_pending_download", "/transactions_completed_download",
                        "employee_controller:generateCompletedTransactionsPDF");