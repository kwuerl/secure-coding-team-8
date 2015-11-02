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
	protected $db_wrapper;
	protected $table_name;
	protected $model_class_name;
	/**
	 * Constructor
	 */
	function __construct($db_wrapper, $table_name, $model_class_name) {
		$this->db_wrapper = $db_wrapper;
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
	public function find($filter, $sort = NULL) {
		$db = $this->db_wrapper->get();
		$query = "SELECT * FROM ".$this->table_name." WHERE ";
		$type_array = array();
		$value_array = array();
		foreach ($filter as $name => $value) {
			$db_field_name = strtoupper($name);
			$query .= $db_field_name . " = :" . $db_field_name . " AND ";

			array_push($type_array, ":" . $db_field_name);
			array_push($value_array, $value);
		}
		$query = preg_replace('/ AND $/', '', $query);

		if (is_array($sort)) {
			$query = $query . " ORDER BY " ;
			foreach ($sort as $column => $order) {
				$query = $query . strtoupper($column) ." ". $order . ",";
			}
		}
		$query = rtrim($query, ",");
		if ($stmt = $db->prepare($query)) {
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
		throw new \Exception("Database error: ".$this->getError($db));
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
		$db = $this->db_wrapper->get();
		if ($stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE ID = :id LIMIT 1;")) {
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
		throw new \Exception("Database error: ".$this->getError($db));
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
		$db = $this->db_wrapper->get();
		if ($stmt = $db->prepare("SELECT * FROM " . $this->table_name . ";")) {
			$result = $this->execute($stmt);
			return $result;
		}
		throw new \Exception("Database error: ".$this->getError($db));
		return false;
	}
    /**
     * Updates a Model Instances to the database
     *
     * @param Model $model_instance	Model instance to update
     * @param array	$fields Fields to be updated in the instance
     * @param array	$filter Condition for update
     *
     * @return boolean
     */
	public function update($model_instance, $fields, $filter) {
		$db = $this->db_wrapper->get();
		$query = "UPDATE " . $this->table_name . " SET ";
		$filter_array = array();

		$reflection_obj = new \ReflectionClass($model_instance);
		$class_properties = $reflection_obj->getProperties();

		foreach ($fields as $property_name) {
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
			$query .= strtoupper($property_name) . " = :" . $property_name . ",";
		}

		$query = rtrim($query, ',');
		$query .= " WHERE ";

		foreach ($filter as $name => $value) {
			$filter_field = ':filter_' . $name;
			$query .= strtoupper($name) . " = " . $filter_field . " AND ";
			$filter_array[$filter_field] = $value;
		}
		$query = preg_replace('/ AND $/', '', $query);
		if ($stmt = $db->prepare($query)) {

			foreach (array_merge($values, $filter_array) as $key => &$value) {
				call_user_func_array(array($stmt, "bindParam"), array($key, &$value));
			}

			$result = $stmt->execute();

			if ($result) {
				$stmt->closeCursor();
				return true;
			}
		}
		throw new \Exception("Database error: ".$this->getError($db));
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
		$db = $this->db_wrapper->get();
		$query = "INSERT INTO " . $this->table_name . " (";
		$query_values = array();
		$query_types = array();
		$query_fields = array();
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
			$query_fields[] = ":" . $col;
			$query .= strtoupper($col) . ",";
			$query_values[] = $val;
			if (is_int($val)) {
				$query_types[] = \PDO::PARAM_INT;
			} else {
				$query_types[] = \PDO::PARAM_STR;
			}
		}
		$query = rtrim($query, ",");
		$query .= ") VALUES(" . implode(",", $query_fields) . ");";

		if ($stmt = $db->prepare($query)) {
			foreach ($query_values as $key => &$value) {
				call_user_func_array(array($stmt, "bindParam"), array($query_fields[$key], &$value, $query_types[$key]));
			}
			$result = $stmt->execute();
			
			if ($result) {
				$model_instance->setId($db->lastInsertId());
				$stmt->closeCursor();
				return true;
			}
		}
		throw new \Exception("Database error: ".$this->getError($db));
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
	 * @param query $query	A valid prepared query
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
	 * @param Connection $db Connection to the database
	 *
	 * @return string|boolean $error|false Returns the error message, if error exists and false otherwise
	 */
	private function getError($db) {
		$error = $db->errorInfo();
		if (count($error) > 0 && !is_null($error[2])) {
			return $error[2];
		}
		return false;
	}
}