<?php
namespace Service;
/**
 * Just wraps Mysqli for usage with the ServiceContainer
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class MysqliWrapperService {
	private $mysqli;
	/**
	 * Constructor: Opens a new connection to the MySQL server
	 *
	 * @param string $host Mysql
	 * @param string $userName Mysql
	 * @param string $password Mysql
	 * @param string $dbName Mysql
	 */
	function __construct ($host, $user_name, $password, $db_name) {
		$this->mysqli = new mysqli($host, $user_name, $password, $db_name);
		if ($connection->connect_error) throw new Exception("Connection Error!");
	}
	/**
	 * @function: Returns a connection to the MySQL server
	 *
	 * @return Returns the mysqli connection
	 */
	public function get() {
		return $this->mysqli;
	}

	/**
	 * Closes the connection to the MySQL server
	 */
	public function close() {
		$this->mysqli->close();
	}

	function __destruct() {
       $this->close();
   	}
}
