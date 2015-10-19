<?php
namespace Helper;
/**
 * Base Class for alle TemplatingHelperExtensions
 *
 * Example Implementation: 
 * <code>
 * <?php
 * class TemplatingTestExtension extends TemplatingHelperExtension {
 *		public function getMethodNames() {
 *			return array("form" => array($this, "createForm"), "form2" => array($this, "createForm2"));
 *		}
 *		public function createForm() {
 *			echo "FORM!";
 *		}
 *		public function createForm2() {
 *			echo "FORM2!";
 *		}
 * }
 * ?>
 * </code>
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
abstract class TemplatingHelperExtension {
	/**
	 * Returns an array of all templating functions this class provides.
	 *
	 * @return array
	 */
	abstract public function getMethodNames();
}