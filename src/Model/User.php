<?php
namespace Model;
/**
 * the User model class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class User {
	protected $id = "";
	protected $first_name = "";
	protected $last_name = "";
	protected $email = "";
	protected $is_active = false;
	protected $_password_plain = "";
	protected $password = "";
	protected $groups_plain = "";
	protected $_provider;
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
		$this->first_name = ucfirst($firstName);
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
		$this->last_name = ucfirst($lastName);
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
	 * Sets the plain password and saves the encrypted password in password.
	 * 
	 * @param string $password
	 */
	public function setPasswordPlain($password) {
		$this->_password_plain = $password;
		$encrypted_password = password_hash($password, PASSWORD_BCRYPT);
		$this->password = $encrypted_password;
	}
	/**
	 * Gets the plain password
	 *
	 * @return string
	 */
	public function getPasswordPlain() {
		return $this->_password_plain;
	}
	/**
	 * Gets the password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}
	/**
	 * Gets the password
	 *
	 * @return string
	 */
	public function setPassword($password) {
		$this->password = $password;
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
	/**
	 * Gets the Users groups
	 *
	 * @return array
	 */
	public function getGroups() {
		return explode(",", $this->groups_plain);
	}
	/**
	 * Sets the Users groups
	 * 
	 * @param array $isActive
	 */
	public function setGroups($groups) {
		$this->groups_plain = implode(",", $groups);
	}
	/**
	 * Gets the Users groups
	 *
	 * @return array
	 */
	public function getGroupsPlain() {
		return $this->groups_plain;
	}
	/**
	 * Sets the Users groups
	 * 
	 * @param array $isActive
	 */
	public function setGroupsPlain($groups) {
		$this->groups_plain = $groups;
	}
	/**
	 * Gets the UserProvider
	 *
	 * @return array
	 */
	public function getProvider() {
		return $this->_provider;
	}
	/**
	 * Sets the UserProvider
	 * 
	 * @param array $isActive
	 */
	public function setProvider($provider) {
		$this->_provider = $provider;
	}
}