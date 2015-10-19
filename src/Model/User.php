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
	private $forename = "";
	private $name = "";
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
	/**
	 * Sets the forename
	 */
	public function setForename($forename) {
		$this->forename = $forename;
	}
	/**
	 * Sets the name
	 */
	public function setName($name) {
		$this->name = $name;
	}
}