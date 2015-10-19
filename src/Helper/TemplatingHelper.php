<?php
namespace Helper;
/**
 * TemplatingHelper is injected into the template and contains the template parameters. Also it allowes "blocks" within the templates and to extend other templates
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class TemplatingHelper {
	private $payload;
	private $blocks = array();
	private $curr_extends = "";
	private $all_extends = array();
	private $current_template_name;
	private $extensions;
	/**
	 * Constructor
	 */
	function __construct($payload, $extensions) {
		$this->payload = $payload;
		$this->extensions = $extensions;
	}
	/**
	 * Can be used from within a template. If used, the provided "extended" template will be used to render the "blocks" defined withn the actual template. 
	 * A Template that uses the "extend" function cannot contain any html outside of "block" definitions. Any present HTML will be ignored.
	 *
	 * @param string $template_path		Template path relative to "Template" directory.
	 */
	public function extend($template_path) {
		if(in_array($template_path, $this->all_extends)) throw new \Exception("Template extends loop detected in ".$current_template_name);
		$extands_stack = $template_path;
	}
	/**
	 * Defines a "block". The block can be overwritten if any other template extends this one. The HTML echoed withn this or any extending block within the same name will be echoed at the space in the base template file where the "block" function is called
	 *
	 * @param string $name	Name of the block
	 * @param string $function	HTML within the Block
	 *
	 * @return string
	 */
	public function block($name, $function) {
		if(!array_key_exists($name, $this->blocks)) {
			$blocks[$name] = $function;
		}
		if (empty($curr_extends)) {
			// calls the block lanbda function
			$blocks[$name]($this);
		}
	}
	/**
	 * Returns the name of the current template
	 *
	 * @return string
	 */
	public function getCurrentTemplateName() {
		return $this->current_template_name;
	}
	/**
	 * Used by the TemplatingService to set the current template name
	 *
	 * @param string $name	Name of the template
	 */
	public function __setCurrentTemplateName($name) {
		$this->current_template_name = $name;
	}
	/**
	 * Used by the TemplatingService to reset the current extends value
	 */
	public function __resetCurrExtends() {
		$this->curr_extends = "";
	}
	/**
	 * Returns the current extended templates name
	 *
	 * @return string
	 */
	public function getCurrExtends() {
		return $this->curr_extends;
	}
	/**
	 * Returns a single template parameter
	 *
	 * @param string $param_name	Parameter name
	 *
	 * @return any
	 */
	public function get($param_name) {
		if(!array_key_exists($param_name, $this->payload)) throw new \Exception("Parameter $param_name does not exist.");
		return $this->payload[$param_name];
	}
	/**
	 * Tries to find the Method in one of the extensions
	 *
	 * @return any
	 */
	public function __call($name, $arguments) 
    {
        foreach ($this->extensions as $extension) {
        	$provided_methods = $extension->getMethodNames();
        	if(array_key_exists($name, $provided_methods)) {
        		$method_description = $provided_methods[$name];
        		return call_user_func_array(array($method_description[0], $method_description[1]), array_merge(array($this),$arguments));
        	}
        }
        throw new \Exception("Function '$name' not found!");
    }
}