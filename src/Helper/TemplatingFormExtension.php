<?php
namespace Helper;

use Service\CSRFService;
/**
 * TemplatingFormExtension can be used to secure forms
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class TemplatingFormExtension extends TemplatingHelperExtension {
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
		return array(
			"form" => array($this, "createForm"),
			"formh" => array($this, "createFormWithHelper"),
			"field" => array($this, "createField")
			);
	}
	/**
	 * Creates a secure form
	 *
	 * @param TemplatingHelper $t
	 * @param array $options	Options for the form //TODO
	 * @param function $closure	Functions that echos the HTML inside the form when called
	 */
	public function createForm($t, $options, $closure) {
		echo "<form";
		foreach ($options as $name=>$option) {
			echo " ".$name."=\"".$option."\"";
		}
		echo ">";
		$closure($t);
		// TODO: CSRF things
		echo "</form>";
	}
	/**
	 * Creates a secure form using a form helper
	 *
	 * @param TemplatingHelper $t
	 * @param FormHelper $helper
	 * @param array $options	Options for the form //TODO
	 * @param function $closure	Functions that echos the HTML inside the form when called
	 */
	public function createFormWithHelper($t, FormHelper $helper, $options, $closure) {
		echo "<form";
		if(!array_key_exists("name", $options)) echo " name=\"".$helper->getName()."\"";
		if(!array_key_exists("method", $options)) echo " method=\"".$helper->getMethod()."\"";
		foreach ($options as $name=>$option) {
			echo " ".$name."=\"".$option."\"";
		}
		echo ">";
		if($helper->useCSRF() == true) {
			
			$token = $helper->createCSRF();
			echo '<input type="hidden" name="'.$helper->getName().'['.$token["key"].']" value="'.$token["token"].'" />';
		}
		$closure($t);
		// TODO: CSRF things
		echo "</form>";
	}
	/**
	 * Creates a form field a form helper
	 *
	 * @param TemplatingHelper $t
	 * @param FormHelper $helper
	 * @param array $options	Options for the form //TODO
	 */
	public function createField($t, FormHelper $helper, $options) {
		//TODO
	}
}