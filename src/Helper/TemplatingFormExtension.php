<?php
namespace Helper;

use Service/CSRFService;
/**
 * TemplatingFormExtension can be used to secure forms
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class TemplatingFormExtension extends TemplatingHelperExtensions {
	private $csrf_service;
	/**
	 * Constructor
	 */
	function __construct(CSRFService $csrf_service) {
		$this->csrf_service = $csrf_service;
	}
	/**
	 * Inherited
	 */
	public function getMethodNames() {
		return array("form" => array($this, "createForm"));
	}
	/**
	 * Creates a secure form
	 *
	 * @param array $options	Options for the form //TODO
	 * @param function $closure	Functions that echos the HTML inside the form when called
	 *
	 * @return any
	 */
	public function createForm($options, $closure) {
		//TODO
	}
}