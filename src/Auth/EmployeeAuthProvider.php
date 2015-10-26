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
	function __construct(EmployeeRepository $employee_repository) {
		$this->employee_repository = $employee_repository;
	}
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	public function login(User $user) {
		return false;
	}
}