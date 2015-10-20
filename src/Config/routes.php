<?php
/**
 *	$routing_service is instance of Service\RoutingService
 */

$routing_service->get("/test/(:all)", "example_controller:testFunction");
$routing_service->get("/form_example", "example_controller:formtest");
$routing_service->post("/form_example", "example_controller:formtest");