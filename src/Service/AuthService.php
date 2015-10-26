<?php
namespace Service;

use Model\UserRepository;
use Model\User;
use Auth\AuthProvider;
/**
 * AuthService is used to manage logins and sessions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class AuthService {
	private $session_service;
	private $user_providers = array();
	/**
	 * Constructor
	 */
	function __construct(SessionService $session_service) {
		$this->session_service = $session_service;
	}
	/**
	 * Returns the current User. If there is none, a blank User is returned.
	 *
	 * @return Model\User
	 */
	public function addUserProvider(AuthProvider $provider) {
		$this->user_providers[] = $provider;
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
		foreach($this->user_providers as $provider) {
			if($user_model = $provider->login($user)) {
				return $user_model;
			}
		}
		return false;
	}
	/**
	 * Checks if the user has certain user groups. If the User does not have the desired Group, this function starts a redirect and throws an exception
	 *
	 * @param User $user	User to check
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
	/**
	 * Registers a user and returns true, if the registration was successful and returns false, if the registration failed.
	 *
	 * @param User $user	User to register
	 *
	 * @return boolean
	 */
	public function register(User $user) {
		
	}
}