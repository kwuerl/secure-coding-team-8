<?php
namespace Model;
/**
 * Repository base class
 * TODO: Should be written in a generic way, so it can handle most of the models
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class Repository {
	protected $mysqli_wrapper;
	protected $table_name;
	protected $model_class_name;
	/**
	 * Constructor
	 */
	function __construct($mysqli_wrapper, $table_name, $model_class_name) {
		$this->mysqli_wrapper = $mysqli_wrapper;
		$this->table_name = $table_name;
		$this->model_class_name = $model_class_name;
	}
	/**
	 * Returns a array of Model Instances that fit for the $filter criteria
	 *
	 * @param array $filter Simple filter array. Example: array("id"=>1)
	 *
	 * @return array
	 */
	public function find($filter) {
		$mysqli = $this->mysqli_wrapper->get();
		$query = "SELECT * FROM ".$this->table_name." WHERE ";
		$type_array = array();
		$value_array = array();
		foreach ($filter as $name => $value) {
			$db_field_name = strtoupper($mysqli->real_escape_string($name));
			$query .= $db_field_name." = ? ";
			if (is_int($value)) {
				array_push($type_array, "i");
			} else if (is_float($value)) {
				array_push($type_array, "d");
			} else {
				array_push($type_array, "s");
			}
			array_push($value_array, $value);
		}
		if ($stmt = $mysqli->prepare($query)) {
			foreach ($type_array as $key => $type) {
				$stmt->bind_param($type, $value_array[$key]);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$model_array = array();
			while ($row = $result->fetch_assoc()) {
				array_push($model_array, $this->fillModel($row));
			}
			$stmt->free_result();
			$stmt->close();
			return $model_array;
		}
	}
	/**
	 * Returns a single Model Instance for ID $id
	 *
	 * @param integer $id ID to match
	 *
	 * @return $model
	 */
	public function get($id) {
		$mysqli = $this->mysqli_wrapper->get();
		if ($stmt = $mysqli->prepare("SELECT * FROM " . $this->table_name . " WHERE ID = ? LIMIT 1;")) {
			$stmt->bind_param('i', $id);
			$result = $this->execute($stmt);

			/*Result will contain a single element and hence return it*/
			return $result[0];
		}
	}
	/**
	 * Returns all instances of the Model
	 *
	 * @param integer $id ID to match
	 *
	 * @return array $result Array of Model instances
	 */
	public function getAll() {
		$mysqli = $this->mysqli_wrapper->get();
		if ($stmt = $mysqli->prepare("SELECT * FROM " . $this->table_name . ";")) {
			$result = $this->execute($stmt);
			return $result;
		}
	}
	/**
	 * Adds a Model Instances to the database and updates its ID field
	 *
	 * @param $model $model_instance	Model Instance
	 *
	 * @return boolean
	 */
	public function add($model_instance) {
		//TODO
	}
	/**
	 * Saves the changes of Model Instances to the database
	 *
	 * @param string $model_instance	Model Instance
	 *
	 * @return string
	 */
	public function save($model_instance) {
		//TODO
	}
	/**
	 * Deletes a Model Instances from the database
	 *
	 * @param string $model_instance	Model Instance
	 *
	 * @return boolean
	 */
	public function delete($model_instance) {
		//TODO
	}
	/**
	 * Executes a query and returns the result.
	 *
	 * @param query $query	A valid mysqli prepared query
	 *
	 * @return object Result of the query execution
	 */
	public function execute($query) {
		/* execute query */
	    $query->execute();
	    $result = $query->get_result();
	    $data = array();
	    /*Populate the model from the result of query execution*/
		while ($row = $result->fetch_assoc()) {
			$data[] = $this->fillModel($row);
		}

		/*Free the result and close the query*/
		$query->free_result();
		$query->close();
		return $data;
	}
	/**
	 * Fills the corresponding model with values.
	 *
	 * @param object|array $model  The model
	 *
	 * @return Model
	 */
	public function fillModel($values) {
		$instance = new $this->model_class_name();
		$reflection_obj = new \ReflectionClass($this->model_class_name);
		foreach ($values as $name => $value) {
			$name_lower = strtolower($name);
			$name_cc = \Helper\StringHelper::underscoreToCamelCase($name_lower, true);
			if ($reflection_obj->hasMethod("set".$name_cc)) {
				call_user_func_array(	
					array($instance, "set".$name_cc),
					array($value)
				);
			} else if ($reflection_obj->hasProperty($name_lower)) {
				$property = $class->getProperty($name_lower);
				$property->setAccessible(true);
				$property->setValue($instance, $value);
			}
		}
		return $instance;
	}
}