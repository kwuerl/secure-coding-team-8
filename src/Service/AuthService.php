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
	private $routing_service;
	private $user_providers = array();
	private $current_user;
	private $login_route_name;
	private $last_message;
	/**
	 * Constructor
	 */
	function __construct(SessionService $session_service, RoutingService $routing_service, $login_route_name) {
		$this->session_service = $session_service;
		$this->routing_service = $routing_service;
		$this->login_route_name = $login_route_name;
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
		return $this->current_user;
	}
	/**
	 * Returns the current User. If there is none, a blank User is returned.
	 *
	 * @return Model\User
	 */
	public function getLastMessage() {
		if($this->session_service->has("auth_last_message")) {
			$msg = $this->session_service->get("auth_last_message");
			$this->session_service->del("auth_last_message");
			return $msg;
		}
		return false;
	}
	/**
	 * Returns the current User. If there is none, a blank User is returned.
	 *
	 * @param string $message
	 */
	public function setLastMessage($message) {
		$this->session_service->set("auth_last_message",$message);
	}
	/**
	 * If User is logged in then redirect user to his home
	 *
	 * @return Model\User
	 */
	public function redirectCurrentUserToUserHome() {
		if($this->isLoggedIn()) {
			if (!$this->session_service->has("redirect_after_login")) {
				$this->routing_service->redirect($this->current_user->getProvider()->getAfterLoginRouteName(), array());
				return true;
			}
		}
		return false;
		
	}
	/**
	 * Returns true if there is any user logged in
	 *
	 * @return boolean
	 */
	public function isLoggedIn() {
		if($this->session_service->has("current_user")) {
			$user = $this->session_service->get("current_user");
			if($user = $this->verify($user)) {
				$this->current_user = $user;
				return true;
			} else {
				$this->session_service->del("current_user");
				return false;
			}
		} else {
			return false;
		}
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
	private function verify(User $user) {
		foreach($this->user_providers as $provider) {
			if($user_model = $provider->verify($user)) {
				$user_model->setProvider($provider);
				return $user_model;
			}
		}
		return false;
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
		if ($user = $this->verify($user)) {
			if ($this->session_service->has("redirect_after_login")) {
				$redirect_after_login = $this->session_service->get("redirect_after_login");
				$redirect_name = $redirect_after_login[0];
				$redirect_params = $redirect_after_login[1];
				$this->session_service->del("redirect_after_login");
			} else {
				$redirect_name = $user->getProvider()->getAfterLoginRouteName();
				$redirect_params = array();
			}
			$this->session_service->reset();
			$this->current_user = $user;
			$sess_user = new User();
			$sess_user->setEmail($user->getEmail());
			$sess_user->setPassword($user->getPassword());
			$this->session_service->clear();
			$this->session_service->set("current_user", $sess_user);
			$this->routing_service->redirect($redirect_name, $redirect_params);
			return true;
		} else {
			$this->session_service->del("current_user");
			return false;
		}
	}
	/**
	 * Checks if the current user has certain user groups. If the User does not have the desired Group, this function starts a redirect and throws an exception
	 *
	 * @param User $user	User to check
	 * @param string $group_expr	Group to check
	 *
	 * @return boolean
	 *
	 * @throws PermissionDeniedException
	 */
	public function check($group_expr) {
		$msg = "";
		if($this->session_service->has("current_user")) {
			$user = $this->session_service->get("current_user");
			if($user = $this->verify($user)) {
				$groups = $user->getGroups();
				if(in_array($group_expr, $groups)) {
					$this->current_user = $user;
					return $this->current_user;
				} else {
					$msg = "You don't have the permission to do this";
				}
			} else {
				$this->session_service->del("current_user");
				$msg = "Could not be logged in";
			}
		} else {
			$msg = "You have to be logged in to see this";
		}
		$this->setLastMessage($msg);
		$request = $this->routing_service->getRequest();
		$prev_url = array($request->getRouteName(), $request->getRouteParams());
		$this->session_service->set("redirect_after_login", $prev_url);
		$this->routing_service->redirect($this->login_route_name, array());
		throw new \Exception($msg);

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
	/**
	 * Registers a user and returns true, if the registration was successful and returns false, if the registration failed.
	 *
	 * @param User $user	User to register
	 *
	 * @return boolean
	 */
	public function logout() {
			$this->session_service->reset();
			$this->routing_service->redirect($this->login_route_name, array());
	}
}