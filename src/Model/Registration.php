<?php
namespace Model;
/**
 * Registration model class
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class Registration {
	private $first_name;
	private $last_name;
	private $email;
	private $password;
	/**
	 * Sets first name
	 *
	 * @param string $first_name
	 */
	public function setFirstName($first_name) {
		$this->first_name = $first_name;
	}
	/**
	 * Gets first name
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->first_name;
	}
	/**
	 * Sets last name
	 *
	 * @param string $last_name
	 */
	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}
	/**
	 * Gets last name
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->last_name;
	}
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