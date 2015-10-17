<?php
namespace Controller;
/**
 * Controller base class. Gets ServiceContainer injected.
 */
class Controller {
	private $service_container;
	/**
	 * Constructor
	 */
	function __construct ($service_container) {
		$this->service_container = $service_container;
	}
	protected function get($service_name) {
		return $this->service_container->get($service_name);
	}
	//TODO
}