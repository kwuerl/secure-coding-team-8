<?php
namespace Helper;
/**
 * Base Class for alle TemplatingHelperExtensions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
abstract class TemplatingHelperExtensions {
	/**
	 * Returns an array of all templating functions this class provides.
	 * Example: array("form" => array($this, "createForm"), "form2" => array($this, "createForm2"))
	 *
	 * @return array
	 */
	abstract public function getMethodNames();
}