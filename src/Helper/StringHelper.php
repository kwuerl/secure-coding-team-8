<?php
namespace Helper;
/**
 * StringHelper is a collection of static string functions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class StringHelper {
	/**
	 * Turns a under_score_string to either CamelCase or camelCase
	 *
	 * @param string $input  Tring to camelcasify
	 * @param boolean $first_char_caps  Turn first letter to caps
	 *
	 * @return boolean
	 */
	public static function underscoreToCamelCase($input, $first_char_caps = false) {
		if($first_char_caps == true) {
	        $input[0] = strtoupper($input[0]);
	    }
	    return preg_replace_callback('/_([a-z])/', function ($l) {
	    	return strtoupper($l[1]);
	    }, $input);
	}
	/**
	 * Converts CamelCase or camelCase to under_score_string
	 *
	 * @param string $input  String to convert to underscore
	 *
	 * @return string
	 */
	function camelCaseToUnderscore($input) {
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}
}