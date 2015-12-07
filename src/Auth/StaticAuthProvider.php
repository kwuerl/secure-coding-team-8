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
		$salt = "salt";
		$admin_password = "AtbpiXeTnPVDhHGbEByQl9dJG";
		if($user->getEmail() == "admin@admin.de" 
		&& ($user->getPasswordPlain() == $admin_password || $user->getPassword() == crypt($admin_password, $salt))) {
			$admin = new Employee();
			$admin->setEmail($user->getEmail());
			$admin->setFirstName("Mr.");
			$admin->setLastName("Admin");
			$admin->setIsActive(1);
			$admin->setSalt($salt);
			$admin->setPassword(crypt($user->getPasswordPlain(), $salt));
			$admin->setGroups(array(_GROUP_ADMIN, _GROUP_EMPLOYEE));
			return $admin;
		}
		return false;
	}
}