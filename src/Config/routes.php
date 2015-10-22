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