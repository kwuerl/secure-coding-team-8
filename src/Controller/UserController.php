<?php
namespace Controller;

class UserController extends Controller {
	public function login($request, $url_param) {
		$this->get("templating")->render("login.html.php", array());
		// TODO: sanitize input
		$data = $request->getData("login");
		$email = array_key_exists("email", $data) ? $data["email"] : null;
		$pw = array_key_exists("password", $data) ? $data["password"] : null;
		if ($email != null & $pw != null) {
			$user = new \Model\User();
			$user->setEmail($email);
			$user->setPasswordPlain($pw);
			// TODO: check in database if exists
			$user_data = $this->get("user_repository")->find(array("email" => $email));
		} else {

		}
	}

	public function register() {
		$this->get("templating")->render("register.html.php", array());
		$data = $request->getData("register");
		$email = array_key_exists("email", $data) ? $data["email"] : null;
		$pw = array_key_exists("password", $data) ? $data["password"] : null;
		$forename = array_key_exists("forename", $data) ? $data["forename"] : null;
		$name = array_key_exists("name", $data) ? $data["name"] : null;
		if ($email != null & $pw != null && $forename != null && $name != null) {
			$user = new \Model\User();
			$user->setEmail($email);
			$user->setPasswordPlain($pw);
			$user->setForename($forename);
			$user->setName($name);
			$this->get("auth")->register($user);
		} else {

		}
	}
}