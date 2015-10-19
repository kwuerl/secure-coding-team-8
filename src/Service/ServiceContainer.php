<?php
namespace Service;
/**
 * ServiceContainer is used to manage service classes 
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class ServiceContainer {
	private $registered_service_map = array();
	private $initialized_service_map = array();
	private $dependency_loop_lock = array();
	/**
	 * registers a service Class within the Service Container
	 *
	 * @param string $service_name	Name of the serivce. Example: "nice_service" 
	 * @param string $class_name 	Fully qualified name of the service class. Example: "\Service\NiceService"
	 * @param array $parameters 	Constructor parameters which will be used to init the Service. 
	 *								Example: 
	 *										array(
	 *											array("type"=>"constant", "value"=>"Nice"), 
	 *											array("type"=>"service", "value"=>"other_service"), 
	 *											array("type"=>"service_container")
	 *										)
	 * @param array $calls 			Functions to be called after construction.  
	 *								Example: 
	 *										array(
	 *											array(
	 *												"function"=>"exampleFunctionName", 
	 *												"parameters"=>array(
	 *													array("type"=>"constant", "value"=>"Nice"), 
	 *													array("type"=>"service", "value"=>"other_service"), 
	 *													array("type"=>"service_container")
	 *												)
	 *											)
	 *										)
	 */
	public function register($service_name, $class_name, $parameters, $calls=null) {
		if($calls==null) $calls = array();
		$this->registered_service_map[$service_name] = array("class_name"=>$class_name,"parameters"=>$parameters, "calls"=>$calls);
	}
	/**
	 * initializes a service class with the provided parameters
	 *
	 * @param string $service_name	Name of the service. Example: "nice_service"
	 *
	 * @return $class_name
	 */
	private function init_service($name) {
		if(in_array($name, $this->dependency_loop_lock)) throw new \Exception("Dependency loop detected in service $name!");
		if(!array_key_exists($name, $this->registered_service_map)) throw new \Exception("Service '$name' not found!");
		$service_config = $this->registered_service_map[$name];
		if(!class_exists($service_config["class_name"]))  throw new \Exception("Service class ".$service_config["class_name"]." does not exist for service $name!");
		// loop lock
		$dependency_loop_lock[] = $name;
		// resolve dependencies
		$constructor_parameters = $this->resolveParameters($service_config["parameters"]);
		$ref = new \ReflectionClass($service_config["class_name"]);
  		$class_instance = $ref->newInstanceArgs($constructor_parameters);
  		$this->initialized_service_map[$name] = $class_instance;
		unset($dependency_loop_lock[$name]);
		//make all function calls
		foreach ($service_config["calls"] as $call) {
			if(array_key_exists("function", $call) && array_key_exists("parameters", $call)) {
				$resolved_paramters = $this->resolveParameters($call["parameters"]);
				call_user_func_array(array($class_instance, $call["function"]), $resolved_paramters);
			}
			
		}
		return $class_instance;
	}
	/**
	 * Resolves the parameters of a function
	 *
	 * @param array $parameter_array	Parameters to resolve
	 *
	 * @return array
	 */
	private function resolveParameters($parameter_array) {
		$resolved_paramters = array();
		//inject all contructor parameters
		foreach($parameter_array as $conf) {
			if ($conf["type"] == "constant") {
				$resolved_paramters[] = $conf["value"];
			} else if ($conf["type"] == "service") {
				$resolved_paramters[] = $this->get($conf["value"]);
			} else if ($conf["type"] == "service_container") {
				$resolved_paramters[] = $this;
			}
		}
		return $resolved_paramters;
	}
	/**
	 * returns the service class
	 *
	 * @param string $service_name	Name of the service. Example: "nice_service"
	 *
	 * @return $class_name
	 */
	public function get($name) {
		if(array_key_exists($name, $this->initialized_service_map)) {
			return $this->initialized_service_map[$name];
		} else {
			return $this->init_service($name);
		}
		
	} 
}