<?php
namespace Service;
/**
 * ParameterService can be used to store and fetch configuration parameters
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class ParameterService {
	private $parameters = array();
	/**
	 * Sets a parameter. Once set it cannot be changed
	 *
	 * @param string $name							Name of the parameter
	 * @param string|integer|float|array $value		Value of the parameter
	 */
	public function set($name, $value) {
		if(array_key_exists($name, $this->parameters)) throw new \Exception("Parameter $name already set!");
		$this->parameters[$name] = $value;
	}
	/**
	 * inits a serice class with the provided parameters
	 *
	 * @param string $name							Name of the parameter
	 *
	 * @return string
	 */
	public function get($name) {
		if(!array_key_exists($name, $this->parameters)) throw new \Exception("Parameter $name not found!");
		return $this->parameters[$name];
	}
}