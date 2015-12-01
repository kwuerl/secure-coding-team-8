<?php
namespace Helper;
/**
 * SanitizationHelper is a collection of static functions that can be used by the FormHelper to sanatize form fields
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class SanitizationHelper {
	//TODO
	public static function rtrim($input) {
		return rtrim($input);
	}

	public static function ltrim($input) {
		return ltrim($input);
	}

	public static function stripTags($input) {
		return filter_var($input, FILTER_SANITIZE_STRING);
	}
}