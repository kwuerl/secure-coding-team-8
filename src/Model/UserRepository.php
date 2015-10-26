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
	 * Returns all User Instances with active status $activeStatus
	 *
	 * @param integer $activeStatus Active status of the user
	 *
	 * @return array $users Instances of the User Model class
	 */
	public function getByActiveStatus ($activeStatus) {

		$statement = "SELECT * FROM " . $this->table_name . " WHERE " . $this->table_name . ".IS_ACTIVE = ? ;";

		/* create a prepared statement */
		if ($query = $this->mysqli_wrapper->get()->prepare($statement)) {
			/* bind parameters for markers */
    		$query->bind_param("i", $activeStatus);
    		$users = $this->execute($query);
    		return $users;
    	}
	}
}