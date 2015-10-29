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
     * Updates the the user registration status to approved or rejected
     *
     * @param Model $userModel User Instance
     * @param string $action Action to perform on the registration
     *
     * @return string|boolean $error|true Error if there is a failure and true otherwise
     */
    public function actOnRegistration($userModel, $action) {

        $db = $this->db_wrapper->get();
        $user_id = $userModel->getId();

        if ($userModel->getIsClosed() == 1) {
            $error = _ERROR_REGISTRATION_CLOSED;
            return $error;
        }
        switch($action) {
            case _ACTION_APPROVE:
                $userModel->setIsActive(1);
                $userModel->setIsClosed(1);
                $result = $this->update($userModel, array("is_active", "is_closed"), array("id" => $user_id));
                break;
            case _ACTION_REJECT:
                $userModel->setIsActive(0);
                $userModel->setIsRejected(1);
                $userModel->setIsClosed(1);
                $result = $this->update($userModel, array("is_active", "is_rejected", "is_closed"), array("id" => $user_id));
                break;
        }
        return ($result == 1) ? "" : $result;
    }
}