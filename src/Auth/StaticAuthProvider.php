<?php
namespace Auth;

use Model\User;
use Model\Employee;
/**
 * StaticAuthProvider is used to login Users that are defined statically
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class StaticAuthProvider extends AuthProvider {
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	public function verify(User $user) {
		if($user->getEmail() == "admin@admin.de" 
		&& password_verify ( "admin" , $user->getPassword() )) {
			$admin = new Employee();
			$admin->setEmail($user->getEmail());
			$admin->setFirstName("Mr.");
			$admin->setLastName("Admin");
			$admin->setIsActive(1);
			$admin->setPassword($user->getPassword());
			$admin->setGroups(array(_GROUP_ADMIN, _GROUP_EMPLOYEE));
			return $admin;
		} else if ($user->getEmail() == "employee@employee.de" 
		&& password_verify ( "employee" , $user->getPassword() )) {
			$employee = new Employee();
			$employee->setEmail($employee->getEmail());
			$employee->setFirstName("Mr.");
			$employee->setLastName("Employee");
			$employee->setIsActive(1);
			$employee->setPassword($employee->getPassword());
			$employee->setGroups(array(_GROUP_EMPLOYEE));
			return $employee;
		} else if ($user->getEmail() == "user@user.de" 
		&& password_verify ( "user" , $user->getPassword() )) {
			$user = new User();
			$user->setEmail($user->getEmail());
			$user->setFirstName("Mr.");
			$user->setLastName("User");
			$user->setIsActive(1);
			$user->setPassword($user->getPassword());
			$user->setGroups(array(_GROUP_USER));
			return $user;
		}
		return false;
	}
}