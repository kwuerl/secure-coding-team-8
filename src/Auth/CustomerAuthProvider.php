<?php
namespace Auth;

use Model\CustomerRepository;
use Model\User;
/**
 * ClientAuthProvider is used to check Client Logins
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class CustomerAuthProvider extends AuthProvider {
	private $customer_repository;
	/**
	 * Constructor
	 */
	function __construct(CustomerRepository $customer_repository, $afer_login_route_name) {
		$this->customer_repository = $customer_repository;
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
		return false;
	}
}