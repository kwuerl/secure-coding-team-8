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
	 * @param string $dbServer Name of the database server
	 * @param string $host Host name or IP address
	 * @param string $userName Username for the database host
	 * @param string $password Password for the database host
	 * @param string $dbName Name of the database on the host
	 */
	function __construct ($dbServer, $host, $user_name, $password, $dbName) {
		$this->mysqli = new \PDO($dbServer . ":host=" . $host .";dbname=" . $dbName, $user_name, $password);

		$error = $this->mysqli->errorInfo();
		if (count($error) > 0 && !is_null($error[2])) {
			throw new \Exception("Connection Error - " . $error[2]);
		}
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
		$this->mysqli = null;
	}

	function __destruct() {
       $this->close();
   	}
}
