<?
namespace Helper;
/**
 * ValidationHelper is a collection of static functions that can be used by the FormHelper to validate form fields
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class ValidationHelper {
	//TODO
	public static function email($input) {
		return true;
	}
	public static function required($input) {
		return !empty($input);
	}
}