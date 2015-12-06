<?php

require_once("Vendor/Psr4ClassLoader.php");
require_once('Vendor/fpdf18/protection/fpdf_protection.php');
require_once('Vendor/fpdf18/mc_table.php');

$loader = new Psr4ClassLoader();
$loader->addPrefix("Service", "Service");
$loader->addPrefix("Helper", "Helper");
$loader->addPrefix("Controller", "Controller");
$loader->addPrefix("Model", "Model");
$loader->addPrefix("Auth", "Auth");
$loader->register();

$service_container = new \Service\ServiceContainer();
require_once("Config/parameters.php");
require_once("Config/services.php");

$routing_service = $service_container->get("routing");
require_once("Config/routes.php");

$routing_service->dispatch();

//TODO: Error Handling

