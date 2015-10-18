<?php
namespace Helper;
/**
 * Class to store and secure all data of the request. It is injected into every controller function by the router
 * TODO: Implement storage of $_GET $_POST and selected $_SERVER variables
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class Request {
	private $query = array();
	/**
	 * Constructor
	 */
	function __construct() {
		$this->query = $_GET;
	}
	/**
	 * Returns the query parameters
	 *
	 * @return array
	 */
	public function getQuery() {
		return $this->query;
	}

}