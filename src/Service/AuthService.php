<?php
namespace Service;

use Model\UserRepository;
use Model\User;
use Auth\AuthProvider;
/**
 * AuthService is used to manage logins and sessions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class AuthService {
	private $session_service;
	private $routing_service;
	private $random_service;
	private $user_providers = array();
	private $current_user;
	private $login_route_name;
	private $last_message;
	/**
	 * Constructor
	 */
	function __construct(SessionService $session_service, RoutingService $routing_service, RandomSequenceGeneratorService $random_service, $login_route_name) {
		$this->session_service = $session_service;
		$this->routing_service = $routing_service;
		$this->random_service = $random_service;
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
		if($this->isLoggedIn()) {
			return $this->current_user;
		}
		return null;
	}
	/**
	 * Returns true if the current user has the right gorups
	 *
	 * @param string $group
	 *
	 * @return Model\User
	 */
	public function currentUserHasGroup($group) {
		$user = $this->getCurrentUser();
		if($user != null) {
			$groups = $user->getGroups();
			if(in_array($group, $groups)) {
				return true;
			}		
		}
		return false;
		
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
	 * @throws UserNotEnabledException
	 * @throws UserLockedException
	 * @throws LoginFailedException
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
	 */
	public function login(User $user) {
		if ($user = $this->verify($user)) {
			// unlock user after successful login
			$user->setLoginAttempts(0);
			$user->setLockedUntil("");
			if (method_exists($user->getProvider(), "getRepository")) {
				$user->getProvider()->getRepository()->update($user, array("login_attempts", "locked_until"), array("email" => $user->getEmail()));
			}

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
			if ($this->session_service->has("redirect_after_login")) {
				$this->session_service->del("redirect_after_login");
			}
			throw new \Exception("UserNotFoundException");
			return false;
		}
	}
	/**
	 * Checks if the current user has certain user groups. If the User does not have the desired Group, this function starts a redirect and throws an exception
	 *
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
					$msg = "You don't have the permission to do this.<br> Either log in as a permitted user or <br> <a href='javascript:history.back()'>Go Back</a>";
				}
			} else {
				$this->session_service->del("current_user");
				$msg = "Could not be logged in";
			}
		} else {
			$msg = "You have to be logged in to see this";
			$request = $this->routing_service->getRequest();
			$prev_url = array($request->getRouteName(), $request->getRouteParams());
			$this->session_service->set("redirect_after_login", $prev_url);
		}
		$this->setLastMessage($msg);
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
	public function logout() {
		$this->session_service->reset();
		$this->routing_service->redirect($this->login_route_name, array());
	}
	/**
	 * Creates a token for password recovery and sets the valid time for it.
	 *
	 * @param User $user
	 *
	 * @return User | boolean
	 */
	public function createToken(User $user) {
		$token = str_replace(array("+", "&", "/"), "", $this->random_service->getString(16));
		// set token valid time to _TOKEN_VALID_TIME minutes
		$token_valid_time = date("Y-m-d H:i:s", time()+(_TOKEN_VALID_TIME*60));
		$user->setToken($token);
		$user->setTokenValidTime($token_valid_time);
		foreach ($this->user_providers as $provider) {
			if (method_exists($provider, 'getRepository')) {
				if ($provider->getRepository()->update(
											$user,
											array("token", "token_valid_time"),
											array("email" => $user->getEmail())
										)) {
					return $user;
				}
			}
		}
		return false;
	}
	/**
	 * Gets the User for a token.
	 *
	 * @param string $token
	 *
	 * @return User | boolean
	 */
	public function getUserFromToken($token) {
		foreach ($this->user_providers as $provider) {
			if (method_exists($provider, 'getRepository')) {
				if ($user = $provider->getRepository()->findOne(array("token" => $token))) {
					if (date("Y-m-d H:i:s") <= $user->getTokenValidTime()) {
						return $user;
					}
				}
			}
		}
		return false;
	}
	/**
	 * Sets a new password for a User and resets token.
	 *
	 * @param string $token
	 * @param string $password
	 *
	 * @return User | boolean
	 */
	public function setNewPassword($token, $password) {
		$model = $this->getUserFromToken($token);
		if ($model !== false) {
			$salt = $this->random_service->getString(16);
			$model->setSalt($salt);
			$model->setPassword(crypt($password, $salt));

			// reset token
			$model->setToken("");
			$model->setTokenValidTime("");

			foreach ($this->user_providers as $provider) {
				if (method_exists($provider, 'getRepository')) {
					if ($provider->getRepository()->update($model, array("salt", "password", "token", "token_valid_time"), array("token" => $token))) {
						return $model;
					}
				}
			}
		}
		return false;
	}
}