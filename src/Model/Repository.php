<?php
namespace Model;
/**
 * Repository base class
 * TODO: Should be written in a generic way, so it can handle most of the models
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
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
	
}