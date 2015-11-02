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
     * @param Model $model User Instance
     * @param string $action Action to perform on the registration
     *
     * @return string|boolean $error|true Error if there is a failure and true otherwise
     */
    public function actOnRegistration($model, $action, $accountRepo = NULL, $accountModel = NULL) {

        $db = $this->db_wrapper->get();
        $user_id = $model->getId();

        if ($model->getIsClosed() == 1) {
            $error = _ERROR_REGISTRATION_CLOSED;
            return $error;
        }
        switch($action) {
            case _ACTION_APPROVE:

                if ($accountModel) {
                    $db->beginTransaction();
                    $model->setIsActive(1);
                    $model->setIsClosed(1);
                    $result = $this->update($model, array("is_active", "is_closed"), array("id" => $user_id));

                    if ($result == 1) {
                        $result = $accountRepo->add($accountModel);
                        if (!$result) {
                            $db->rollBack();
                            return $result;
                        }
                        $db->commit();
                    } else {
                        $db->rollBack();
                        return $result;
                    }
                } else {
                    $model->setIsActive(1);
                    $model->setIsClosed(1);
                    $result = $this->update($model, array("is_active", "is_closed"), array("id" => $user_id));
                }

                break;
            case _ACTION_REJECT:
                $model->setIsActive(0);
                $model->setIsRejected(1);
                $model->setIsClosed(1);
                $result = $this->update($model, array("is_active", "is_rejected", "is_closed"), array("id" => $user_id));
                break;
        }
        return ($result == 1) ? "" : $result;
    }
}