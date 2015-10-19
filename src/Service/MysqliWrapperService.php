<?php
namespace Service;
/**
 * Just wraps Mysqli for usage with the ServiceContainer
 *
 * @modified Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class MysqliWrapperService {
	private $mysqli;
	/**
	 * Constructor
	 */
	function __construct ($host, $user) {
		//TODO
		$mysqli = "TODO";
	}
	/**
	 * @function: Opens a new connection to the MySQL server
	 *
	 * @params:
	 * 		host:   Name/IP address of the host
	 * 		userName: User name to connect to the server
	 * 		password: Password to connect to the server
	 * 		dbName:   Name of the database on the server
	 *
	 * @returns: Returns the newly created connection
	 *
	 *
	 */
	public function get($host, $userName, $password, $dbName) {
		$connection = new mysqli($host, $userName, $password, $dbName);
		if (!$connection->connect_error)
			return $connection;
		/*TODO: error handling*/
	}

	/**
	 * @function: Closes the connection to the MySQL server
	 *
	 * @params:
	 * 		connection: Connection to the MySQL server
	 *
	 * @return
	 */
	public function close($connection) {
		$connection->close();
	}
}
