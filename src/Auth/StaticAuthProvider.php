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
		&& crypt("admin", $user->getPassword()) == $user->getPassword()) {
			$admin = new Employee();
			$admin->setEmail($user->getEmail());
			$admin->setFirstName("Mr.");
			$admin->setLastName("Admin");
			$admin->setIsActive(1);
			$admin->setPassword($user->getPassword());
			$admin->setGroups(array(_GROUP_ADMIN, _GROUP_EMPLOYEE));
			return $admin;
		}
		return false;
	}
}