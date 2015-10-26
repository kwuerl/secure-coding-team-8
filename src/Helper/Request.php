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
	private $data = array();
	private $server = array();
	private $route_name = "";
	private $route_params = array();
	/**
	 * Constructor
	 */
	function __construct() {
		$this->query = $_GET;
		$this->data = $_POST;
		$this->server = $_SERVER;
	}
	/**
	 * Returns the query ($_GET) parameter for a given key
	 *
	 * @param string $name	Key
	 *
	 * @return string
	 */
	public function getQuery($name) {
		if (isset($this->query[$name])) {
			return $this->query[$name];
		} else {
			return null;
		}
	}
	/**
	 * Returns the data ($_POST) parameter for a given key
	 *
	 * @param string $name	Key
	 *
	 * @return mixed
	 */
	public function getData($name) {
		if (isset($this->data[$name])) {
			return $this->data[$name];
		} else {
			return null;
		}
	}
	/**
	 * Returns the server parameter for a given key
	 *
	 * @return string
	 */
	public function getServer($name) {
		if (isset($this->server[$name])) {
			return $this->server[$name];
		} else {
			return null;
		}
	}
	/**
	 * Sets the name of the current route
	 */
	public function setRouteName($name) {
		$this->route_name = $name;
	}
	/**
	 *Sets the current routes parameters
	 */
	public function setRouteParams($params) {
		$this->route_params = $params;
	}
	/**
	 * Sets the name of the current route
	 *
	 * @return string
	 */
	public function getRouteName() {
		return $this->route_name;
	}
	/**
	 *Sets the current routes parameters
	 *
	 * @return array
	 */
	public function getRouteParams() {
		return $this->route_params;
	}
}