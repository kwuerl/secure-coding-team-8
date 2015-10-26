<?php
namespace Auth;

use Model\User;
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
	public function login(User $user) {
		if($user->getEmail() == "admin@admin.de" 
		&& $user->getPasswordPlain() == "admin") 
			return true;
		return false;
	}
}