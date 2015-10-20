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

	public function setEmail($email) {
		$this->email = $email;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function getPassword() {
		return $this->password;
	}
}