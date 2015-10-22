<?php
namespace Model;
/**
 * Login model class
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class Login {
	private $email;
	private $password;
	/**
	 * Sets email
	 *
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	/**
	 * Gets email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}
	/**
	 * Sets password
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}
	/**
	 * Gets password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}
}