<?php
namespace Helper;
/**
 * ValidationHelper is a collection of static functions that can be used by the FormHelper to validate form fields
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class ValidationHelper {
	//TODO
	public static function email($input) {
		return filter_var($input, FILTER_VALIDATE_EMAIL);
	}
	public static function required($input) {
		return !empty($input);
	}
	public static function name($input) {
		return preg_match("/^[a-zA-ZäöüÄÖÜ][a-zA-ZäöüÄÖÜ\-\s]+$/", $input);
	}
}