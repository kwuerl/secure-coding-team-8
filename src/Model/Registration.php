<?php
namespace Model;
/**
 * Registration model class
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class Registration {
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