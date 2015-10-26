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

$service_container->register("csrf", "Service\\CSRFService", array(
	array("type"=>"service", "value"=>"session")
));

$service_container->register("mysqli_wrapper", "Service\\MysqliWrapperService", array(
	_MYSQL_HOST, _MYSQL_USER, _MYSQL_PASSWORD, _MYSQL_DATABASE
));

// ------------  Auth  -----------------

$service_container->register("customer_auth_provider", "Auth\\CustomerAuthProvider", array(
	array("type"=>"service", "value"=>"customer_repository")
));

$service_container->register("employee_auth_provider", "Auth\\EmployeeAuthProvider", array(
	array("type"=>"service", "value"=>"employee_repository")
));

$service_container->register("static_auth_provider", "Auth\\StaticAuthProvider", array(
));

$service_container->register("auth", "Service\\AuthService", array(
	array("type"=>"service", "value"=>"session")
), array(
	array("function"=>"addUserProvider", "parameters"=>array(
		array("type"=>"service", "value"=>"customer_auth_provider")
	)),
	array("function"=>"addUserProvider", "parameters"=>array(
		array("type"=>"service", "value"=>"employee_auth_provider")
	)),
	array("function"=>"addUserProvider", "parameters"=>array(
		array("type"=>"service", "value"=>"static_auth_provider")
	))
));

// ------------  Templating   -----------------

$service_container->register("templating_form_extension", "Helper\\TemplatingFormExtension", array(
	array("type"=>"service", "value"=>"csrf")
));

$service_container->register("templating", "Service\\TemplatingService", array(
), array(
	array("function"=>"addTemplateHelperExtension", "parameters"=>array(
		array("type"=>"service", "value"=>"templating_form_extension")
	))
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

$service_container->register("customer_controller", "Controller\\CustomerController", array(
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
	"",
	_CLASS_MODEL_USER
));

$service_container->register("customer_repository", "Model\\CustomerRepository", array(
	array("type"=>"service", "value"=>"mysqli_wrapper"),
	_TBL_CUSTOMER,
	_CLASS_MODEL_CUSTOMER
));

$service_container->register("employee_repository", "Model\\EmployeeRepository", array(
	array("type"=>"service", "value"=>"mysqli_wrapper"),
	_TBL_EMPLOYEE,
	_CLASS_MODEL_EMPLOYEE
));

$service_container->register("transaction_repository", "Model\\TransactionRepository", array(
	array("type"=>"service", "value"=>"mysqli_wrapper"),
	_TBL_TRANSACTION,
	_CLASS_MODEL_TRANSACTION
));