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
	function __construct(CustomerRepository $customer_repository) {
		$this->customer_repository = $customer_repository;
	}
	/**
	 * Checks Login for a certain User and returns either the logged in User or false
	 *
	 * @param User The use we try to log in
	 *
	 * @return User|boolean
	 */
	public function login(User $user) {
		return false;
	}
}