<?php
namespace Model;
/**
 * the User model class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
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
	 * 
	 * @param string $firstName
	 */
	public function setFirstName($firstName) {
		$this->first_name = $firstName;
	}
	/**
	 * Sets the last name
	 * 
	 * @param string $lastName
	 */
	public function setLastName($lastName) {
		$this->last_name = $lastName;
	}
	/**
	 * Sets the email
	 * 
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	/**
	 * Sets the plain password
	 * 
	 * @param string $password
	 */
	public function setPasswordPlain($password) {
		$this->password_plain = $password;
	}
	/**
	 * Sets the active status
	 * 
	 * @param boolean $isActive
	 */
	public function setIsActive($isActive) {
		$this->is_active = $isActive;
	}
}