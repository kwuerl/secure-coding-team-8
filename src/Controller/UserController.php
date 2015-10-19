<?php
namespace Controller;

class UserController extends Controller {
	public function login($request, $url_param) {
		$this->get("templating")->render("login.html.php", array());
		// TODO: sanitize input
		$email = $request->getData("login[email]");
		$pw = $request->getData("login[password]");
		if ($email != null & $pw != null) {
			$user = new \Model\User();
			$user->setEmail($email);
			$user->setPasswordPlain($pw);
			$this->get("auth")->check($user);
		} else {

		}
	}

	public function register() {

	}
}