<?php
namespace Model;
/**
 * Repository class for the User model
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class UserRepository extends Repository {
	/**
	 * Constructor
	 */
	function __construct($mysqli_wrapper) {
		$this->mysqli_wrapper = $mysqli_wrapper;
	}
	/**
	 * Returns a single User Instance for ID $id
	 *
	 * @param integer $id ID to match
	 *
	 * @return User $user An instance of the User Model class
	 */
	public function get($id) {
		$statement = "SELECT *
		 				from TBL_CUSTOMER
		 				WHERE ID = ?";

		/* create a prepared statement */
		if ($query = $this->mysqli_wrapper->get()->prepare($statement)) {
			/* bind parameters for markers */
    		$query->bind_param("i", $id);
    		$result = $this->execute($query)[0];
    		$user = new User();
    		$user->setFirstName($result["FIRST_NAME"]);
    		$user->setLastName($result["LAST_NAME"]);
    		$user->setEmail($result["EMAIL"]);
    		return $user;
    	}
	}
}