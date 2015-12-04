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
	protected $salt = "";
	protected $groups_plain = "";
	protected $registration_date = "";
	protected $is_closed = 0;
	protected $is_rejected = 0;
	protected $_provider;
	protected $token = "";
	protected $token_valid_time = "";
	protected $login_attempts = 0;
	protected $locked_until = "";
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
	 * Gets the salt
	 *
	 * @return string
	 */
	public function getSalt() {
		return $this->salt;
	}
	/**
	 * Gets the salt
	 *
	 * @return string
	 */
	public function setSalt($salt) {
		$this->salt = $salt;
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
	/**
	 * Gets the closed status of the user registration
	 *
	 * @return integer
	 */
	public function getIsClosed() {
		return $this->is_closed;
	}
	/**
	 * Sets the closed status of the user registration
	 *
	 * @param integer $isClosed
	 */
	public function setIsClosed($isClosed) {
		$this->is_closed = $isClosed;
	}
	/**
	 * Gets the rejected status of the user registration
	 *
	 * @return integer
	 */
	public function getIsRejected() {
		return $this->is_rejected;
	}
	/**
	 * Sets the rejected status of the user registration
	 *
	 * @param integer $isRejected
	 */
	public function setIsRejected($isRejected) {
		$this->is_rejected = $isRejected;
	}
	/**
	 * Gets the registration date
	 *
	 * @return timestamp
	 */
	public function getRegistrationDate() {
		return $this->registration_date;
	}
	/**
	 * Sets the registration date
	 *
	 * @param timestamp $registrationDate
	 */
	public function setRegistrationDate($registrationDate) {
		$this->registration_date = $registrationDate;
	}
	/**
	 * Gets the token
	 *
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}
	/**
	 * Sets the token
	 *
	 * @param string
	 */
	public function setToken($token) {
		$this->token = $token;
	}
	/**
	 * Gets the token valid time
	 *
	 * @return timestamp
	 */
	public function getTokenValidTime() {
		return $this->token_valid_time;
	}
	/**
	 * Sets the token valid time
	 *
	 * @param timestamp $tokenValidTime
	 */
	public function setTokenValidTime($tokenValidTime) {
		$this->token_valid_time = $tokenValidTime;
	}
	/**
	 * Gets the number of login attempts
	 *
	 * @return integer
	 */
	public function getLoginAttempts() {
		return $this->login_attempts;
	}
	/**
	 * Sets the numer of login attempts
	 *
	 * @param integer
	 */
	public function setLoginAttempts($loginAttempts) {
		$this->login_attempts = $loginAttempts;
	}
	/**
	 * Gets the locked until time
	 *
	 * @return timestamp
	 */
	public function getLockedUntil() {
		return $this->locked_until;
	}
	/**
	 * Sets the locked until time
	 *
	 * @param timestamp $lockedUntil
	 */
	public function setLockedUntil($lockedUntil) {
		$this->locked_until = $lockedUntil;
	}
}