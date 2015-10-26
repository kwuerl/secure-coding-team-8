<?php
namespace Auth;

use Model\User;
/**
 * AuthProvider is the base class for all AuthProviders. Auth Providers are used to check User logins
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
abstract class AuthProvider {
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	abstract public function login(User $user);
}