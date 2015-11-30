<?php
namespace Helper;
/**
 * ValidationHelper is a collection of static functions that can be used by the FormHelper to validate form fields
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class ValidationHelper {
	/**
	 * Checks if $input is a valid email
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 *
	 * @return boolean
	 */
	public static function email(FormHelper $helper, $input) {
		return filter_var($input, FILTER_VALIDATE_EMAIL);
	}
	/**
	 * Checks if $input is not empty
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 *
	 * @return boolean
	 */
	public static function required(FormHelper $helper, $input) {
		return !empty($input);
	}
	/**
	 * Checks if $input is a valid name defined as having at least 2 characters and other than letters only '-' and white space is allowed
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 *
	 * @return boolean
	 */
	public static function name(FormHelper $helper, $input) {
		return preg_match("/^[a-zA-ZäöüÄÖÜ][a-zA-ZäöüÄÖÜ\-\s]+$/u", $input);
	}
	/**
	 * Checks if $input is a valid password
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 *
	 * @return boolean
	 */
	public static function password(FormHelper $helper, $input) {
		return preg_match("/^[a-zA-Z0-9\\\+\?\^\$#\-_]+$/", $input);
	}
	/**
	 * Checks if $input has the same value as the fields defined in $fields
	 *
	 * @param FormHelper $helper
	 * @param string $input    The input string
	 * @param string $field    The field to compare to
	 *
	 * @return boolean
	 */
	public static function equal(FormHelper $helper, $input, $field) {
		$equal = false;
		$cmp_value = $helper->getValue($field);
		if ($input === $cmp_value) {
			$equal = true;
		}
		return $equal;
	}
	/**
	 * Checks if $input is a number
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 *
	 * @return boolean
	 */
	public static function number(FormHelper $helper, $input) {
		return is_numeric($input);
	}
	/**
	 * Checks if $input length <= $maxLength
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 * @param int $maxLength
	 *
	 * @return boolean
	 */
	public static function maxLength(FormHelper $helper, $input, $maxLength=0) {
		if ($maxLength > 0) {
			if (strlen($input) <= $maxLength) {
				return true;
			}
		}
		return false;
	}
	/**
	 * Checks if $input is a valid address
	 *
	 * @param FormHelper $helper
	 * @param string $input
	 *
	 * @return boolean
	 */
	public static function address(FormHelper $helper, $input) {
		return preg_match("/^[a-zA-ZäöüÄÖÜ][a-zA-ZäöüÄÖÜ\-\s.]+[0-9\-]+[a-zA-Z]*$/u", $input);
	}
}