<?php
namespace Auth;

use Model\Repository;
use Model\User;
/**
 * DBAuthProvider is used to check Client Logins
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class DBAuthProvider extends AuthProvider {
	private $repository;
	/**
	 * Constructor
	 */
	function __construct(Repository $repository, $afer_login_route_name) {
		$this->repository = $repository;
		parent::__construct($afer_login_route_name);
	}
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	public function verify(User $user) {
		if ($user_db = $this->repository->findOne(array("email"=>$user->getEmail()))) {
			if (date("Y-m-d H:i:s") >= $user_db->getLockedUntil()) {
				if( crypt($user->getPasswordPlain(), $user_db->getSalt()) == $user_db->getPassword()
				|| $user->getPassword() == $user_db->getPassword()) {
					if ($user_db->getIsActive()) {
						return $user_db;
					} else {
						throw new \Exception("UserNotEnabledException");
					}
				} else {
					// wrong password
					$login_attempts = (int) $user_db->getLoginAttempts();
					if ($login_attempts >= 4) {
						$user_db->setLoginAttempts(5);
						$locked_until = date("Y-m-d H:i:s", time()+(_LOCKED_TIME*60));
						$user_db->setLockedUntil($locked_until);
						$this->repository->update($user_db, array("login_attempts", "locked_until"), array("email" => $user_db->getEmail()));
					} else {
						$login_attempts++;
						$user_db->setLoginAttempts($login_attempts);
						$this->repository->update($user_db, array("login_attempts"), array("email" => $user_db->getEmail()));
					}
					throw new \Exception("LoginFailedException");
				}
			} else {
				throw new \Exception("UserLockedException");
			}
		}
		return false;
	}
	/**
	 * Returns repository
	 *
	 * @return Model\Repository
	 */
	public function getRepository() {
		return $this->repository;
	}
}