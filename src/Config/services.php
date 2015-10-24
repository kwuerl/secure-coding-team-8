<?php
/**
 *	$service_container is instance of Service\ServiceContainer
 */
// ------------   Services  -----------------

$service_container->register("routing", "Service\\RoutingService", array(
	array("type"=>"service_container")
));

$service_container->register("random", "Service\\RandomSequenceGeneratorService", array(
));

$service_container->register("session", "Service\\SessionService", array(
	array("type"=>"service", "value"=>"random")
));

$service_container->register("auth", "Service\\AuthService", array(
	array("type"=>"service", "value"=>"user_repository"),
	array("type"=>"service", "value"=>"param")
));

$service_container->register("csrf", "Service\\CSRFService", array(
	array("type"=>"service", "value"=>"session")
));

$service_container->register("templating", "Service\\TemplatingService", array(
), array(
	array("function"=>"addTemplateHelperExtension", "parameters"=>array(
		array("type"=>"service", "value"=>"templating_form_extension")
	))
));

$service_container->register("mysqli_wrapper", "Service\\MysqliWrapperService", array(
	array("type"=>"constant", "value"=>$service_container->get("param")->get("mysql_host")),
	array("type"=>"constant", "value"=>$service_container->get("param")->get("mysql_user")),
	array("type"=>"constant", "value"=>$service_container->get("param")->get("mysql_password")),
	array("type"=>"constant", "value"=>$service_container->get("param")->get("mysql_database"))
));

// ------------  Templating Extensions  -----------------

$service_container->register("templating_form_extension", "Helper\\TemplatingFormExtension", array(
	array("type"=>"service", "value"=>"csrf")
));

// ------------  Controllers  -----------------

$service_container->register("example_controller", "Controller\\ExampleController", array(
	array("type"=>"service_container")
));

$service_container->register("login_controller", "Controller\\LoginController", array(
	array("type"=>"service_container")
));

$service_container->register("registration_controller", "Controller\\RegistrationController", array(
	array("type"=>"service_container")
));

$service_container->register("user_controller", "Controller\\UserController", array(
	array("type"=>"service_container")
));

$service_container->register("employee_controller", "Controller\\EmployeeController", array(
	array("type"=>"service_container")
));
// ------------  Repositories  -----------------

$service_container->register("example_repository", "Model\\ExampleRepository", array(
	array("type"=>"service", "value"=>"mysqli_wrapper")
));

$service_container->register("user_repository", "Model\\UserRepository", array(
	array("type"=>"service", "value"=>"mysqli_wrapper"),
	array("type"=>"constant", "value"=>"TBL_CUSTOMER"),
	array("type"=>"constant", "value"=>"\Model\User")
));

$service_container->register("transaction_repository", "Model\\TransactionRepository", array(
	array("type"=>"service", "value"=>"mysqli_wrapper"),
	array("type"=>"constant", "value"=>"TBL_TRANSACTION"),
	array("type"=>"constant", "value"=>"\Model\Transaction")
));