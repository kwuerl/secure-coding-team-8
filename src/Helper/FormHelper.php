<?php
namespace Helper;

use \Helper\SanitizationHelper;
use \Helper\ValidationHelper;
/**
 * FormService can be used to sanatize form data and map post data to objects
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class FormHelper {
	private $field_configs = array();
	private $field_values = array();
	private $method;
	private $uniq_name;
	private $error_messages = array();
	/**
	 * Constructor
	 */
	function __construct($uniq_name, $method="POST") {
		$this->method = $method;
		$this->uniq_name = $uniq_name;
	}
	/**
	 * Adds a form field to the FormHelper
	 *
	 * Example:
	 * <code>
	 * <?php
	 * $helper = new FormFelper("test_form");
	 * $helper->addField("test_field", "text", array(
	 * 		array("required", "Field is required"),
	 * 		array("lengthMinMax", "Field must be 1 to 5 digits long", array(1,5))
	 * ), array("ltrim", "rtrim"), "default value");
	 * ?>
	 * </code>
	 *
	 * @param string $name  Name of the form field. If you want to use this helper to later fill a model this should have the same name as the model property
	 * @param string $type  Type of the form field: email, textarea, text, password, ...
	 * @param array $validations 	Validation rules for the model field. $validations is an array(validation_function[,message[,option_array]]). validation_function is a static function in the class ValidationHelper.
	 * @param array $sanitizations 	Sanitization rules for the model field. Form is an array(sanitization_function). sanitization_function is a static function in the class SanitizationHelper.
	 * @param string $default 	Default value
	 *
	 * @return FormHelper
	 */
	public function addField($name, $type, $validations, $sanitizations, $default="") {
		if(array_key_exists($name, $this->field_configs)) throw new Exception("Can't add the same field '$name' twice!");
		$field_config = array();
		$field_config["validations"] = $validations;
		$field_config["sanitizations"] = $sanitizations;
		$field_config["default"] = $default;
		$this->field_configs[$name] = $field_config;
		$this->field_values[$name] = $default;
		return $this;
	}
	/**
	 * Runs all validations and sanitizations on the Request
	 *
	 * @param string $name  Name of the form field. If you want to use this helper to later fill a model this should have the same name as the model property
	 *
	 * @return boolean
	 */
	public function processRequest(Request $request) {
		// fetch GET or POST data
		if($this->method == "POST") {
			$data = $request->getData($this->uniq_name);
		} else if ($this->method == "GET") {
			$data = $request->getQuery($this->uniq_name);
		}
		if($data == null) return false;

		// get Reflection Class
		$sanitization_helper_reflec = new \ReflectionClass('Helper\SanitizationHelper'); 

		$error_messages = array();

		// loop through all field configs
		foreach ($this->field_configs as $name=>$config) {

			$field_raw = "";
			//get from request or set to default
			if(array_key_exists($name, $data)) {
				$field_raw = $data[$name];
			} else {
				$field_raw = $config["default"];
			}

			// run all sanitizations
			foreach($config["sanitizations"] as $sanitization) {
				//see if SanitizationHelper has the right function
				if($sanitization_helper_reflec->hasMethod($sanitization)) {
					$sanitization_helper_reflec_method = $sanitization_helper_reflec->getMethod($sanitization);
					if($sanitization_helper_reflec_method->isPublic() && $sanitization_helper_reflec_method->isStatic()) {
						//run the function 
						$field_raw = call_user_func_array(__NAMESPACE__ .'\SanitizationHelper::'.$sanitization, array($field_raw));
					} else {
						 throw new Exception("Sanitization function '$type' is not accessible !");
					}
				} else {
					throw new Exception("Sanitization function '$type' does not exist !");
				}
			}
			// save the field value
			$this->field_values[$name] = $field_raw;
		}
		return true;
	}
	/**
	 * Runs all validations and sanitizations on the Request
	 *
	 * @param string $name  Name of the form field. If you want to use this helper to later fill a model this should have the same name as the model property
	 *
	 * @return boolean
	 */
	public function validate() {
		// get Reflection Classes
		$validation_helper_reflec = new \ReflectionClass('Helper\ValidationHelper'); 

		$error_messages = array();

		// loop through all field configs
		foreach ($this->field_configs as $name=>$config) {
			$error_messages_field = array();

			//check all validations
			foreach($config["validations"] as $validation) {
				if(is_array($validation) && sizeof($validation)>0) {

					$type = $validation[0];

					$message = "";
					if(sizeof($validation)>1 && is_string($validation[1])) $message = $validation[1];

					$options = array();
					if(sizeof($validation)>2 && is_array($validation[2])) $options = $validation[2];

					//see if ValidationHelper has the right function
					if($validation_helper_reflec->hasMethod($type)) {
						$validation_helper_reflec_method = $validation_helper_reflec->getMethod($type);
						if($validation_helper_reflec_method->isPublic() && $validation_helper_reflec_method->isStatic()) {
							//run the function 
							$valid = call_user_func_array(__NAMESPACE__ .'\ValidationHelper::'.$type, array_merge(array($this->field_values[$name]),$options));
							//if invalid add the error message
							if(!$valid) {
								$error_messages_field[] = $message;
							}
						} else {
							 throw new Exception("Validation function '$type' is not accessible!");
						}
					} else {
						throw new Exception("Validation function '$type' does not exist!");
					}
				}
			}

			//if any validation failed add the error message
			if(sizeof($error_messages_field)>0) {
				$this->error_messages[$name] = $error_messages_field;
			}
		}
		if(sizeof($this->error_messages)>0) {
			return false;
		}
		return true;
	}
	/**
	 * Fills a model object or array with the form data. If the model is an object it first tries to call the setter for the property. For test_prop it would try to call setTestProp($value).
	 *
	 * @param object|array $model  The model
	 */
	public function fillModel($model) {
		if(is_object($model)) {
			$class = get_class($model);
			$reflec =  new \ReflectionClass($model);
			foreach ($this->field_values as $name=>$field_value) {
				$name_cc = StringHelper::underscoreToCamelCase($name, true);
				if($reflec->hasMethod("set".$name_cc)) {
					call_user_func_array(array($model,"set".$name_cc),array($field_value));
				} else if($reflec->hasProperty($name)) {
					$property = $class->getProperty($name);
					$property->setAccessible(true);
					$property->setValue($model, $field_value);
				}
			}
		} else if(is_array($model)) {
			foreach ($this->field_values as $name=>$field_value) {
				if(array_key_exists($name, $model)) {
					$model[$name] = $field_value;
				}
			}
		}
	}
	/**
	 * Returns the values as array
	 *
	 * @return array
	 */
	public function getValues() {
		return $this->field_values;
	}
	/**
	 * Returns a single form value
	 *
	 * @param string $name The field name
	 *
	 * @return array
	 */
	public function getValue($name) {
		if(array_key_exists($name, $this->field_values)) {
			return $this->field_values[$name];
		} else {
			return "";
		}
		
	}
	/**
	 * Returns the form name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->uniq_name;
	}
	/**
	 * Returns the form method
	 *
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}
	/**
	 * Returns all form errors
	 *
	 * @return string
	 */
	public function getErrors() {
		return $this->error_messages;
	}
	/**
	 * Returns all errors for a single field
	 *
	 * @param string $name The field name
	 *
	 * @return array
	 */
	public function getError($name) {
		if(array_key_exists($name, $this->error_messages)) {
			return $this->error_messages[$name];
		} else {
			return array();
		}
	}

}