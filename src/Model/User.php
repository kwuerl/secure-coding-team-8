<?php
namespace Model;
/**
 * the User model class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class User {
	private $id = "";
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
	 * Gets the user id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Sets the user id
	 *
	 * @param integer $id
	 */
	public function setId($userId) {
		$this->id = $userId;
	}
	/**
	 * Gets the first name
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->first_name;
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
	 * Gets the last name
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->last_name;
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
	 * Gets the email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
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
	 * Gets the plain password
	 *
	 * @return string
	 */
	public function getPasswordPlain() {
		return $this->password_plain;
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
	 * Gets the active status
	 *
	 * @return boolean
	 */
	public function getIsActive() {
		return $this->is_active;
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