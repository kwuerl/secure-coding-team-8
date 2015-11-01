<?php
/**
 *	$routing_service is instance of Service\RoutingService
 */

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
 * Customer routes
 */
$routing_service->get("overview", "/overview", "customer_controller:loadOverview");
$routing_service->get("profile", "/profile", "customer_controller:loadProfile");
$routing_service->get("transaction_history", "/transaction_history", "customer_controller:loadTransactionHistory");
$routing_service->get("make_transfer_get", "/make_transfer", "transaction_controller:makeTransfer");
$routing_service->post("make_transfer_post", "/make_transfer", "transaction_controller:makeTransfer");
$routing_service->post("transaction_history_download", "/transaction_history_download", "customer_controller:generateTransactionPDF");
$routing_service->get("statement", "/statement", "customer_controller:loadStatement");

/*
 * Employee routes
 */
$routing_service->get("employee_overview", "/employee_overview", "employee_controller:loadOverview");
$routing_service->get("employee_profile", "/employee_profile", "employee_controller:loadProfile");
$routing_service->get("customers_get", "/customers", "employee_controller:loadCustomersList");
$routing_service->post("customers_post", "/customers", "employee_controller:actOnCustomerRegistrations");
$routing_service->get("customer_detail", "/customer_details/(:num)", "employee_controller:loadCustomerDetails");
$routing_service->get("employees_get", "/employees","employee_controller:loadEmployeesList");
$routing_service->post("employees_post", "/employees","employee_controller:actOnEmployeeRegistrations");
$routing_service->get("transactions_get", "/transactions","employee_controller:loadPendingTransactions");
$routing_service->post("transactions_post", "/transactions","employee_controller:actOnTransactions");