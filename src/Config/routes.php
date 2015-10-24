<?php
/**
 *	$routing_service is instance of Service\RoutingService
 */

$routing_service->get("/test/(:all)", "example_controller:testFunction");
$routing_service->get("/form_example", "example_controller:formtest");
$routing_service->post("/form_example", "example_controller:formtest");
$routing_service->get("/login", "login_controller:processLogin");
$routing_service->post("/login", "login_controller:processLogin");
$routing_service->get("/register", "registration_controller:processRegistration");
$routing_service->post("/register", "registration_controller:processRegistration");
$routing_service->get("/overview", "user_controller:loadOverview");
$routing_service->get("/profile", "user_controller:loadProfile");
$routing_service->get("/transaction_history", "user_controller:loadTransactionHistory");
$routing_service->get("/make_transfer", "user_controller:makeTransfer");
$routing_service->get("/overview", "employee_controller:loadOverview");
$routing_service->get("/profile", "employee_controller:loadProfile");
$routing_service->get("/customers", "employee_controller:loadCustomersList");
$routing_service->get("/customer_details", "employee_controller:loadCustomerDetails");
$routing_service->get("/approve_registrations","employee_controller:approveRegistration");