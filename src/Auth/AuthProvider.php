<?php
namespace Auth;

use Model\User;
/**
 * AuthProvider is the base class for all AuthProviders. Auth Providers are used to check User logins
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
abstract class AuthProvider {
	private $afer_login_route_name;
	/**
	 * Constructor
	 */
	function __construct($afer_login_route_name) {
		$this->afer_login_route_name = $afer_login_route_name;
	}
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	abstract public function verify(User $user);
	/**
	 * Returns the name of the route that shoulb be redirected to after login
	 *
	 * @return string
	 */
	public function getAfterLoginRouteName() {
		return $this->afer_login_route_name;
	}
}