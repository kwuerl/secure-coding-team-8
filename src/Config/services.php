<?php

$service_container->register("routing", "Service\\RoutingService", array(
	array("type"=>"service_container")
));

$service_container->register("templating", "Service\\TemplatingService", array(
));

$service_container->register("mysqli_wrapper", "Service\\RoutingService", array(
	array("type"=>"constant", "value"=>$service_container->get("param")->get("mysql_host")),
	array("type"=>"constant", "value"=>$service_container->get("param")->get("mysql_user"))
));

$service_container->register("example_controller", "Controller\\ExampleController", array(
	array("type"=>"service_container")
));

$service_container->register("example_repository", "Model\\ExampleRepositoryController", array(
	array("type"=>"service", "value"=>"mysqli_wrapper")
));