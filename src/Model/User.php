<?php
namespace Model;
/**
 * the User model class
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class User {
	private $email = "";
	private $password_plain = "";
	/**
	 * Constructor
	 */
	function __construct() {
		
	}
	/**
	 * Sets the email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	/**
	 * Sets the plain password
	 */
	public function setPasswordPlain($password) {
		$this->password_plain = $password;
	}
}