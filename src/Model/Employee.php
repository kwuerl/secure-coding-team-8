<?php
namespace Model;
/**
 * The Employee model class
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class Employee extends User {
	private $is_authorized;

	/**
	 * Sets the authorized status
	 */
	public function setIsAuthorized($isAuthorized) {
		$this->is_authorized = $isAuthorized;
	}
}