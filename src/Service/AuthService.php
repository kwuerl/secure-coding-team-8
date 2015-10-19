<?php
namespace Service;

use Model\User;
/**
 * AuthService is used to manage logins and sessions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
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
	 * @param User $user	User to login
	 *
	 * @return boolean
	 *
	 * @throws UserNotFoundException
	 * @throws UserNotEnabledException
	 */
	public function login(User $user) {
		//TODO
		return true;
	}
	/**
	 * Cheks if the user has certain user groups. If the User does not have the desired Group, this function starts a redirect and throws an exception
	 *
	 * @param User $name	User to check
	 * @param string $group_expr	Group to check
	 *
	 * @return boolean
	 *
	 * @throws PermissionDeniedException
	 */
	public function check(User $user, $group_expr) {
		//TODO
		return true;
	}
	/**
	 * Cheks if the current user has certain user groups. If the current User does not have the desired Group, this function starts a redirect and throws an exception
	 *
	 * @param string $group_expr	Group to check
	 *
	 * @return boolean
	 *
	 * @throws PermissionDeniedException
	 */
	public function checkCurrentUser($group_expr) {
		//TODO
		return true;
	}
}