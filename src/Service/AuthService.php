<?php
namespace Service;

use Model\User;
/**
 * AuthService is used to manage logins and sessions
 */
class AuthService {
	$user_repo;
	$param_service;
	/**
	 * Constructor
	 */
	function __construct(UserRepository $user_repo, ParameterService $param_service) {
		$this->user_repo = $user_repo;
		$this->param_service = $param_service;
	}
	/**
	 * Returns the current User. If there is none, a blank User is returned. 
	 *
	 * @return Model\User
	 */
	public function getCurrentUser() {
		//TODO
	}
	/**
	 * Tries to login a User  
	 *
	 * @param string $name	Name of the parameter
	 *
	 * @return boolean
	 *
	 * @throws UserNotFoundException
	 * @throws UserNotEnabledException
	 */
	public function login(User $user) {
		//TODO
	}
	/**
	 * Cheks if the user has certain user groups. If the current User does not have the desired Group, this function starts a redirect and throws an exception
	 *
	 * @param string $name	Name of the parameter
	 *
	 * @return boolean
	 *
	 * @throws PermissionDeniedException
	 */
	public function check(User $user, $group_expr) {
		//TODO
	}
}