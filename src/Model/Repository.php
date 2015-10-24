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
		if ($stmt = $mysqli->prepare("SELECT * FROM ".$this->table_name." WHERE ID = ? LIMIT 1;")) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				return $this->fillModel($row);
			}
			$stmt->free_result();
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

		$metaData = $query->result_metadata();

		while ($field = $metaData->fetch_field()) {
		  	$parameters[] = &$row[$field->name];
		}

	    /* bind result variables */
		call_user_func_array(array($query, 'bind_result'), $parameters);

		$result = array();
	    /* fetch values */
		while ($row = $query->fetch()) {
		  	foreach($row as $key => $val) {
		    	$temp[$key] = $val;
		  	}
		  	$result[] = $temp;
		}
	    /* close the query */
	    $query->close();

	    return $result;
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