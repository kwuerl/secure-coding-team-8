<?php
namespace Service;
/**
 * Just wraps the database connection for usage with the ServiceContainer
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class DbWrapperService {
	private $db;
	/**
	 * Constructor: Opens a new connection to the database server
	 *
	 * @param string $dbServer Name of the database server
	 * @param string $host Host name or IP address
	 * @param string $userName Username for the database host
	 * @param string $password Password for the database host
	 * @param string $dbName Name of the database on the host
	 */
	function __construct ($dbServer, $host, $user_name, $password, $dbName) {
		$this->db = new \PDO($dbServer . ":host=" . $host .";dbname=" . $dbName, $user_name, $password);

		$error = $this->db->errorInfo();
		if (count($error) > 0 && !is_null($error[2])) {
			throw new \Exception("Connection Error - " . $error[2]);
		}
	}
	/**
	 * @function: Returns a connection to the database server
	 *
	 * @return Returns the connection
	 */
	public function get() {
		return $this->db;
	}

	/**
	 * Closes the connection to the database server
	 */
	public function close() {
		$this->db = null;
	}

	function __destruct() {
       $this->close();
   	}
}
