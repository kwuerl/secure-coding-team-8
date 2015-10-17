<?php
namespace \Model

class Repository {
	private $mysqli_wrapper;
	function __constructor($mysqli_wrapper) {
		$this->mysqli_wrapper = $mysqli_wrapper;
	}
	public function find($filter) {
		//TODO
	}
	public function get() {
		//TODO
	}
	public function add() {
		//TODO
	}
	public function delete() {
		//TODO
	}
	public function save() {
		//TODO
	}
}