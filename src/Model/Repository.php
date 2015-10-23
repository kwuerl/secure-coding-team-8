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
	private $mysqli_wrapper;
	/**
	 * Constructor
	 */
	function __construct($mysqli_wrapper) {
		$this->mysqli_wrapper = $mysqli_wrapper;
	}
	/**
	 * Returns a array of Model Instances that fit for the $filter criteria
	 *
	 * @param array $filter Simple filter array. Example: array("id"=>1)
	 *
	 * @return array
	 */
	public function find($filter) {
		//TODO
	}
	/**
	 * Returns a single Model Instance for ID $id
	 *
	 * @param integer $id ID to match
	 *
	 * @return $model
	 */
	public function get($id) {
		//TODO
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

	    /* fetch values */
		while ($query->fetch()) {
		  	foreach($row as $key => $val) {
		    	$temp[$key] = $val;
		  	}
		  	$result[] = $temp;
		}

	    /* close the query */
	    $query->close();

	    return $result;
	}
}