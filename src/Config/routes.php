<?php
/**
 *	$routing_service is instance of Service\RoutingService
 */

$routing_service->get("test_route", "/test/(:all)/(:all)/(:any)", "example_controller:testFunction");
$routing_service->get("form_example_get", "/form_example", "example_controller:formtest");
$routing_service->post("form_example_post", "/form_example", "example_controller:formtest");
/*
 * Login and registration routes
 */
$routing_service->get("login_get", "/login", "login_controller:processLogin");
$routing_service->post("login_post", "/login", "login_controller:processLogin");
$routing_service->get("register_get", "/register", "registration_controller:processRegistration");
$routing_service->post("register_post", "/register", "registration_controller:processRegistration");

/*
 * Customer routes
 */
$routing_service->get("overview", "/overview", "customer_controller:loadOverview");
$routing_service->get("profile", "/profile", "customer_controller:loadProfile");
$routing_service->get("transaction_history", "/transaction_history", "customer_controller:loadTransactionHistory");
$routing_service->get("make_transfer", "/make_transfer", "customer_controller:makeTransfer");
/*
 * Employee routes
 */
$routing_service->get("employee_overview", "/employee_overview", "employee_controller:loadOverview");
$routing_service->get("employee_profile", "/employee_profile", "employee_controller:loadProfile");
$routing_service->get("customers", "/customers", "employee_controller:loadCustomersList");
$routing_service->get("customer_detail", "/customer_details/(:num)", "employee_controller:loadCustomerDetails");
$routing_service->get("approve_registration", "/approve_registrations","employee_controller:approveRegistrations");
$routing_service->get("approve_transactions", "/approve_transactions","employee_controller:approveTransactions");