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

$service_container->register("flash_bag", "Service\\FlashBagService", array(
	array("type"=>"service", "value"=>"session")
));

$service_container->register("csrf", "Service\\CSRFService", array(
	array("type"=>"service", "value"=>"session"),
	array("type"=>"service", "value"=>"random")
));

$service_container->register("form", "Service\\FormService", array(
	array("type"=>"service", "value"=>"csrf")
));

$service_container->register("db_wrapper", "Service\\DbWrapperService", array(
	_DB_SERVER, _MYSQL_HOST, _MYSQL_USER, _MYSQL_PASSWORD, _MYSQL_DATABASE
));

$service_container->register("email", "Service\\EmailService", array(
	_EMAIL
));

$service_container->register("pdf", "Service\\PdfService", array(
));

$service_container->register("transaction_code", "Service\\TransactionCodeService", array(
	array("type"=>"service", "value"=>"transaction_code_repository"),
	array("type"=>"service", "value"=>"random")
));

$service_container->register("scs", "Service\\SCSService", array(
	array("type"=>"service", "value"=>"scs_repository"),
	array("type"=>"service", "value"=>"random")
));

$service_container->register("account", "Service\\AccountService", array(
	array("type"=>"service", "value"=>"account_repository")
));

$service_container->register("customer", "Service\\CustomerService", array(
	array("type"=>"service", "value"=>"account_repository"),
	array("type"=>"service", "value"=>"customer_repository"),
	array("type"=>"service", "value"=>"account"),
	array("type"=>"service", "value"=>"transaction_code"),
	array("type"=>"service", "value"=>"pdf"),
	array("type"=>"service", "value"=>"email"),
	array("type"=>"service", "value"=>"scs")
));

// ------------  Auth  -----------------

$service_container->register("customer_auth_provider", "Auth\\CustomerAuthProvider", array(
	array("type"=>"service", "value"=>"customer_repository"),
	_CUSTOMER_START_PAGE
));

$service_container->register("employee_auth_provider", "Auth\\EmployeeAuthProvider", array(
	array("type"=>"service", "value"=>"employee_repository"),
	_EMPLOYEE_START_PAGE
));

$service_container->register("static_auth_provider", "Auth\\StaticAuthProvider", array(
	_EMPLOYEE_START_PAGE
));

$service_container->register("auth", "Service\\AuthService", array(
	array("type"=>"service", "value"=>"session"),
	array("type"=>"service", "value"=>"routing"),
	array("type"=>"service", "value"=>"random"),
	_LOGIN_ROUTE_NAME
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

$service_container->register("templating_flash_bag_extension", "Helper\\TemplatingFlashBagExtension", array(
	array("type"=>"service", "value"=>"flash_bag")
));

$service_container->register("templating_user_extension", "Helper\\TemplatingUserExtension", array(
	array("type"=>"service", "value"=>"auth")
));

$service_container->register("templating", "Service\\TemplatingService", array(
), array(
	array("function"=>"addTemplateHelperExtension", "parameters"=>array(
		array("type"=>"service", "value"=>"templating_form_extension")
	)),
	array("function"=>"addTemplateHelperExtension", "parameters"=>array(
		array("type"=>"service", "value"=>"templating_flash_bag_extension")
	)),
	array("function"=>"addTemplateHelperExtension", "parameters"=>array(
		array("type"=>"service", "value"=>"templating_user_extension")
	))
));

// ------------  Controllers  -----------------

$service_container->register("default_controller", "Controller\\DefaultController", array(
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

$service_container->register("transaction_controller", "Controller\\TransactionController", array(
	array("type"=>"service_container")
));
// ------------  Repositories  -----------------

$service_container->register("example_repository", "Model\\ExampleRepository", array(
	array("type"=>"service", "value"=>"db_wrapper")
));

$service_container->register("user_repository", "Model\\UserRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	"",
	_CLASS_MODEL_USER
));

$service_container->register("customer_repository", "Model\\CustomerRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	_TBL_CUSTOMER,
	_CLASS_MODEL_CUSTOMER
));

$service_container->register("employee_repository", "Model\\EmployeeRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	_TBL_EMPLOYEE,
	_CLASS_MODEL_EMPLOYEE
));

$service_container->register("account_repository", "Model\\AccountRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	_TBL_ACCOUNT,
	_CLASS_MODEL_ACCOUNT
));

$service_container->register("transaction_repository", "Model\\TransactionRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	_TBL_TRANSACTION,
	_CLASS_MODEL_TRANSACTION
));

$service_container->register("transaction_code_repository", "Model\\TransactionCodeRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	_TBL_TRANSACTION_CODE,
	_CLASS_MODEL_TRANSACTION_CODE
));

$service_container->register("scs_repository", "Model\\SCSRepository", array(
	array("type"=>"service", "value"=>"db_wrapper"),
	_TBL_SCS,
	_CLASS_MODEL_SCS
));