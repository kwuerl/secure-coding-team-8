<?php
namespace Model;
/**
 * Repository class for the User model
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 * @author Vivek Sethia <vivek.sethia@tum.de>
 */
abstract class UserRepository extends Repository {
    /**
     * Updates the the user registration status
     *
     * @param array $userId - user id
     *
     * @return string|boolean $error|true Error if there is a failure and true otherwise
     */
    public function approveRegistration($userId) {

        $db = $this->db_wrapper->get();
        $userId = (int)$userId;

        if ($this->isClosed($userId)) {
            $error = _ERROR_REGISTRATION_CLOSED;
            return $error;
        }
        $statement = "UPDATE " . $this->table_name . " SET IS_ACTIVE = 1 WHERE ID = :id";

        $db->beginTransaction();

        /* create a prepared statement */
        if ($query = $db->prepare($statement)) {
            /* bind parameters for markers */
            $query->bindParam(':id', $userId);
            $query->execute();

            $db->commit();
            $error = $this->getError($db, true);
            if (!$error) {
                $this->close($userId);
            }
            return $error;
        }
    }

     /**
     * Updates the the user registration status
     *
     * @param array $userId - user id
     *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
     */
    public function rejectRegistration($userId) {
        $db = $this->db_wrapper->get();
        $userId = (int)$userId;

        if ($this->isClosed($userId)) {
            $error = _ERROR_REGISTRATION_CLOSED;
            return $error;
        }
        $statement = "UPDATE " . $this->table_name . " SET IS_ACTIVE = 0, IS_REJECTED = 1 WHERE ID = :id";

        $db->beginTransaction();

        /* create a prepared statement */
        if ($query = $db->prepare($statement)) {
            /* bind parameters for markers */
            $query->bindParam(':id', $userId);
            $query->execute();

            $db->commit();
            $error = $this->getError($db);
            if (!$error) {
                $this->close($userId);
            }
            return $error;
        }
    }
    /**
	 * Closes the registration indicating that actions have already been performed on it.
	 *
	 * @param integer $userId Id of the user
	 *
	 * @return string|boolean $error|true Error if there is a failure and true otherwise
	 */
	public function close($userId) {
		$db = $this->db_wrapper->get();
		$userId = (int)$userId;
		$statement = "UPDATE " . $this->table_name . " SET IS_CLOSED = 1 WHERE ID= :userId";

		$db->beginTransaction();

		/* create a prepared statement */
		if ($query = $db->prepare($statement)) {
			/* bind parameters for markers */
			$query->bindParam(':userId', $userId);
			$query->execute();

			$db->commit();
			$error = $this->getError($db);
			return $error;
		}
	}

	/**
	 * Checks the closed status of the registration
	 *
	 * @param integer $userId Id of the user
	 *
	 * @return integer $status Closed status of the registration
	 */
	public function isClosed($userId) {
		$db = $this->db_wrapper->get();
		$userId = (int)$userId;
		$statement = "SELECT IS_CLOSED FROM " . $this->table_name . " WHERE ID = :userId";

		/* create a prepared statement */
		if ($query = $db->prepare($statement)) {
			/* bind parameters for markers */
			$query->bindParam(':userId', $userId);
			$query->execute();

			$status = $query->fetchColumn();
			return $status;
		}
	}
    /**
     * Gets the error from the database
     *
     * @param Connection $db Connection to the database
     *
     * @return string|boolean $error|false Returns the error message, if error exists and false otherwise
     */
    private function getError($db, $isRollBack = false) {
        $error = $db->errorInfo();
        if (count($error) > 0 && !is_null($error[2])) {
            if ($isRollBack) {
                $db->rollBack();
            }
            return $error[2];
        }
        return false;
    }
}