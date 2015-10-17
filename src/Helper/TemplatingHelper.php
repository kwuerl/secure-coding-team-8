<?php
namespace Helper;

class TemplatingHelper {
	private $payload;
	private $blocks = array();
	private $curr_extends = "";
	private $all_extends = array();
	private $current_template_name;
	function __construct($payload) {
		$this->payload = $payload;
	}
	public function extend($template_path) {
		if(in_array($template_path, $this->all_extends)) throw new \Exception("Template extends loop detected in ".$current_template_name);
		$extands_stack = $template_path;
	}
	public function block($name, $function) {
		if(!array_key_exists($name, $this->blocks)) {
			$blocks[$name] = $function;
		}
		if (empty($curr_extends)) {
			$blocks[$name]($this);
		}
	}
	public function getCurrentTemplateName() {
		return $this->current_template_name;
	}
	public function __setCurrentTemplateName($name) {
		$this->current_template_name = $name;
	}
	public function __resetCurrExtends() {
		$this->curr_extends = "";
	}
	public function getCurrExtends() {
		return $this->curr_extends;
	}
	public function get($param_name) {
		if(!array_key_exists($param_name, $this->payload)) throw new \Exception("Parameter $param_name does not exist.");
		return $this->payload[$param_name];
	} 
}