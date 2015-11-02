<?php
namespace Helper;

use Service\AuthService;
/**
 * TemplatingFormExtension can be used to secure forms
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class TemplatingUserExtension extends TemplatingHelperExtension {
	private $auth_service;
	/**
	 * Constructor
	 */
	function __construct(AuthService $auth_service) {
		$this->auth_service = $auth_service;
	}
	/**
	 * Inherited
	 */
	public function getMethodNames() {
		return array(
			"current_user" => array($this, "getCurrentUser"),
			"user_is_logged_in" => array($this, "userIsLoggedIn"),
			"current_user_has_group" => array($this, "currentUserHasGroup"),
		);
	}
	/**
	 * Returns all FLashMessages
	 *
	 * @param TemplatingHelper $t
	 */
	public function getCurrentUser($t) {
		return $this->auth_service->getCurrentUser();
	}
	/**
	 * Returns all FLashMessages
	 *
	 * @param TemplatingHelper $t
	 */
	public function userIsLoggedIn($t) {
		return $this->auth_service->isLoggedIn();
	}
	/**
	 * Returns true if the current user has the right gorups
	 *
	 * @param TemplatingHelper $t
	 */
	public function currentUserHasGroup($t, $group) {
		return $this->auth_service->currentUserHasGroup($group);
	}
}