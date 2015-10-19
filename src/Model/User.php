<?php
namespace Model;
/**
 * the User model class
 *
 * @modified Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class User {
	private $first_name = "";
	private $last_name = "";
	private $email = "";
	private $is_active = false;
	private $password_plain = "";
	/**
	 * Constructor
	 */
	function __construct() {
		
	}
	/**
	 * Sets the first name
	 */
	public function setFirstName($firstName) {
		$this->first_name = $firstName;
	}
	/**
	 * Sets the last name
	 */
	public function setLastName($lastName) {
		$this->last_name = $lastName;
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
	 * Sets the active status
	 */
	public function setIsActive($isActive) {
		$this->is_active = $isActive;
	}
}