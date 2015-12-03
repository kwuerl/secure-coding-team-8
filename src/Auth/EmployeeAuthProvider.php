<?php
namespace Auth;

use Model\EmployeeRepository;
use Model\User;
/**
 * EmployeeAuthProvider is used to check Employee Logins
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class EmployeeAuthProvider extends AuthProvider {
	private $employee_repository;
	/**
	 * Constructor
	 */
	function __construct(EmployeeRepository $employee_repository, $afer_login_route_name) {
		$this->employee_repository = $employee_repository;
		parent::__construct($afer_login_route_name);
	}
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	public function verify(User $user) {
		if($user_db = $this->employee_repository->findOne(array("email"=>$user->getEmail()))) {
			if(crypt($user->getPasswordPlain(), $user_db->getSalt()) == $user_db->getPassword() 
			|| $user->getPassword() == $user_db->getPassword()) {
				if($user_db->getIsActive()) {
					return $user_db;
				}
			}
		}
		return false;
	}
	/**
	 * Returns employee repository
	 *
	 * @return Model\Repository
	 */
	public function getRepository() {
		return $this->employee_repository;
	}
}