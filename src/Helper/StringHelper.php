<?php
/**
 * StringHelper is a collection of static string functions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
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
}