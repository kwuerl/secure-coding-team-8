<?php
namespace Service;

class ParameterService {
	private $parameters = array();
	public function set($name, $value) {
		if(array_key_exists($name, $this->parameters)) throw new \Exception("Parameter $name already set!");
		$this->parameters[$name] = $value;
	}
	public function get($name) {
		if(!array_key_exists($name, $this->parameters)) throw new \Exception("Parameter $name not found!");
		return $this->parameters[$name];
	}
}