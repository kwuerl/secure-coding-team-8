<?php
namespace Model;
/**
 * Repository base class
 * TODO: Should be written in a generic way, so it can handle most of the models
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
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
	 * @return array|boolean
	 */
	public function find($filter) {
		$mysqli = $this->mysqli_wrapper->get();
		$query = "SELECT * FROM ".$this->table_name." WHERE ";
		$type_array = array();
		$value_array = array();
		foreach ($filter as $name => $value) {
			$db_field_name = strtoupper($name);
			$query .= $db_field_name . " = :" . $db_field_name;

			array_push($type_array, ":" . $db_field_name);

			array_push($value_array, $value);
		}
		if ($stmt = $mysqli->prepare($query)) {
			foreach ($type_array as $key => $type) {
				$stmt->bindParam($type, $value_array[$key]);
			}
			$stmt->execute();
			$model_array = array();
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				array_push($model_array, $this->fillModel($row));
			}
			$stmt->closeCursor();
			return $model_array;
		}
		throw new \Exception("MySQL error: ".$this->getError($mysqli));
		return false;
	}
	/**
	 * Returns a one Model Instances that fit for the $filter criteria or false
	 *
	 * @param array $filter Simple filter array. Example: array("id"=>1)
	 *
	 * @return array|boolean
	 */
	public function findOne($filter) {
		$result = $this->find($filter);
		if (sizeof($result) > 0) {
			return $result[0];
		}
		return false;
	}
	/**
	 * Returns a single Model Instance for ID $id
	 * If no Model was found, return false
	 *
	 * @param integer $id ID to match
	 *
	 * @return $model|boolean
	 */
	public function get($id) {
		$mysqli = $this->mysqli_wrapper->get();
		if ($stmt = $mysqli->prepare("SELECT * FROM " . $this->table_name . " WHERE ID = :id LIMIT 1;")) {
			$stmt->bindParam(':id', $id);
			$result = $this->execute($stmt);
			if (is_array($result)) {
				if (sizeof($result) > 0) {
					$stmt->closeCursor();
					return $result[0];
				} else
					return $result;
			}
		}
		throw new \Exception("MySQL error: ".$this->getError($mysqli));
		return false;
	}
	/**
	 * Returns all instances of the Model
	 *
	 * @param integer $id ID to match
	 *
	 * @return array|boolean $result Array of Model instances
	 */
	public function getAll() {
		$mysqli = $this->mysqli_wrapper->get();
		if ($stmt = $mysqli->prepare("SELECT * FROM " . $this->table_name . ";")) {
			$result = $this->execute($stmt);
			return $result;
		}
		throw new \Exception("MySQL error: ".$this->getError($mysqli));
		return false;
	}
	/**
	 * Adds a Model Instances to the database and updates its ID field
	 *
	 * @param $model $model_instance	Model Instance
	 *
	 * @return boolean
	 */
	public function add($model_instance) {
		$mysqli = $this->mysqli_wrapper->get();
		$query = "INSERT INTO " . $this->table_name . " (";
		$query_values = array();
		$query_types = "";
		$reflection_obj = new \ReflectionClass($model_instance);
		$class_properties = $reflection_obj->getProperties();
		$values = array();
		foreach ($class_properties as $property) {
			$property_name = $property->getName();
			if ($property_name[0] !== "_") {
				$name_lower = strtolower($property_name);
				$name_cc = \Helper\StringHelper::underscoreToCamelCase($name_lower, true);
				if ($reflection_obj->hasMethod("get".$name_cc)) {
					$value = call_user_func_array(	
						array($model_instance, "get".$name_cc),
						array()
					);
				} else {
					$property->setAccessible(true);
					$value = $property->getValue($model_instance);
				}
				if ($value !== null) {
					if (is_bool($value)) {
						$values[$property_name] = (int)$value;
					} else {
						$values[$property_name] = $value;
					}
				}
			}
		}
		foreach ($values as $col => $val) {
			$query .= strtoupper($col).",";
			$query_values[] = $val;
			if (is_int($val)) {
				$query_types .= "i";
			} else if (is_float($val)) {
				$query_types .= "d";
			} else {
				$query_types .= "s";
			}
		}
		$query = rtrim($query, ",");
		$query_values_str = rtrim(str_repeat("?,", sizeof($values)), ",");
		$query .= ") VALUES(" . $query_values_str . ");";
		if ($stmt = $mysqli->prepare($query)) {
			$parameters = array();
			foreach ($query_values as $key => &$value) {
				$parameters[$key] = &$value;
			}
			call_user_func_array(array($stmt, "bind_param"), array_merge(array($query_types), $parameters));
			$result = $stmt->execute();
			
			if ($result) {
				$model_instance->setId($stmt->insert_id);
				$stmt->close();
				return true;
			}
		}
		throw new \Exception("MySQL error: ".$this->getError($mysqli));
		return false;
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
	protected function execute($query) {
		/* execute query */
	    $query->execute();
	    $data = array();
	    /*Populate the model from the result of query execution*/
		while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
			$data[] = $this->fillModel($row);
		}

		/*Free the result and close the query*/
		$query->closeCursor();
		return $data;
	}
	/**
	 * Fills the corresponding model with values.
	 *
	 * @param object|array $model  The model
	 *
	 * @return Model
	 */
	protected function fillModel($values) {
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
	/**
	 * Gets the error from the database
	 *
	 * @param Mysqli $mysqli Connection to the database
	 *
	 * @return string|boolean $error|false Returns the error message, if error exists and false otherwise
	 */
	private function getError($mysqli) {
		$error = $mysqli->errorInfo();
		if (count($error) > 0 && !is_null($error[2])) {
			return $error[2];
		}
		return false;
	}
}