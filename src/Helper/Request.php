<?php
namespace Helper;

class Request {
	private $query = array();
	function __construct() {
		$this->query = $_GET;
	}
	public function getQuery() {
		return $this->query;
	}

}