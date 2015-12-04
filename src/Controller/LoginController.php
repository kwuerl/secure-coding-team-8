<?php
namespace Controller;

/**
 * Login Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class LoginController extends Controller {

	public function processLogin ($request) {
		if($this->get("auth")->redirectCurrentUserToUserHome()) return;
		if($msg = $this->get("auth")->getLastMessage()) $this->get("flash_bag")->add("Authentification failed", $msg, "error");
		// create the FormHelper
		$helper = new \Helper\FormHelper("form_login");

		//add one field
		$helper->addField("email", "text", array(
			array("required", "Email is required"),
			array("email", "Please input a valid e-mail")
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("_password_plain", "text", array(
			array("required", "Password is required")
		), array("ltrim", "rtrim", "stripTags"), "");

		// try to process the request
		if($helper->processRequest($request)) {

			//try to validate
			if($helper->validate()) {

				// fill the model
				$model = new \Model\User();
				$helper->fillModel($model);

				// AuthService
				if (!$this->get("auth")->login($model)) {
					$this->get("flash_bag")->add("Login failed", "Unfortunately the Login failed", "error");
				} 
			}
		} 
		// render the form
		$this->get("templating")->render("form_login.html.php", array(
			"form" => $helper
		));
	}

	public function logout($request) {
		$this->get("auth")->logout();
	}

	public function resetPassword($request) {
		$helper = new \Helper\FormHelper("recover_password");

		$helper->addField("email", "text", array(
			array("required", "Email is required"),
			array("email", "Please input a valid e-mail")
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("employee", "checkbox", array(), array(), "");

		if ($helper->processRequest($request)) {
			if ($helper->validate()) {
				$email = $helper->getValue("email");
				$employee = $helper->getValue("employee");

				if ($employee == "on") {
					$model = $this->get("employee_repository")->findOne(array("email" => $email));
					$e = "y";
				} else {
					$model = $this->get("customer_repository")->findOne(array("email" => $email));
					$e = "n";
				}

				if ($model !== false) {
					$user = $this->get("auth")->createToken($model);

					if ($user !== false) {
						$url = $_SERVER['SERVER_NAME'].$this->get("routing")->url("reset_password_get", array())."?token=".$token."&e=".$e;
						$token = $user->getToken();

						// send email with pw reset link
						$this->get("email")->sendMail(
							$user->getEmail(),
							"Password reset for your account at SecureBank",
							"Dear ".$user->getFirstName()." ".$user->getLastName()."\r\nclick on the link to reset your password for your account at SecureBank:\r\n".$url."\r\n\r\nHave a nice day,\r\nyour SecureBank"
						);

						$this->get("flash_bag")->add("Reset successful", "You will get an e-mail with further information soon.", "success");
						$this->get("routing")->redirect("login_get", array());
					} else {
						$this->get("flash_bag")->add("An error occurred", "Please try again later.", "error");
					}				
				} else {
					// there is no account with this email
					$this->get("flash_bag")->add("Reset failed", "There is no account with this e-mail.", "error");
				}
			}
		}

		$this->get("templating")->render("form_recover_password.html.php", array(
			"form" => $helper
		));
	}

	public function getPasswordResetView($request) {
		$helper = new \Helper\FormHelper("reset_password");

		$helper->addField("_password_plain", "password", array(
			array("required", "Password is required"),
			array("minLength", "Has to be at least 6 characters long", array(6)),
			array("password", "Must contain at least one lowercase character, one uppercase character and at least one digit.")
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("password_repeat", "password", array(
			array("required", "Please repeat your password"),
			array("equal", "Passwords do not match", array("_password_plain"))
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("token", "text", array(
			array("required", "Token has to be set")
		), array("ltrim", "rtrim", "stripTags"), "");

		if ($token = $request->getQuery("token")) {
			if ($user = $this->get("auth")->getUserFromToken($token)) {
				$this->get("templating")->render("form_reset_password.html.php", array(
					"form" => $helper,
					"token" => $token
				));
				return;
			}
		}
		$this->get("flash_bag")->add("Token invalid", "The token is either invalid or has expired.", "error");
		$this->get("routing")->redirect("recover_password_get", array());
	}

	public function processPasswordReset($request) {
		$helper = new \Helper\FormHelper("reset_password");

		$helper->addField("_password_plain", "password", array(
			array("required", "Password is required"),
			array("minLength", "Has to be at least 6 characters long", array(6)),
			array("password", "Must contain at least one lowercase character, one uppercase character and at least one digit.")
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("password_repeat", "password", array(
			array("required", "Please repeat your password"),
			array("equal", "Passwords do not match", array("_password_plain"))
		), array("ltrim", "rtrim", "stripTags"), "");

		$helper->addField("token", "text", array(
			array("required", "Token has to be set")
		), array("ltrim", "rtrim", "stripTags"), "");

		if ($helper->processRequest($request)) {
			if ($helper->validate()) {
				if ($user = $this->get("auth")->setNewPassword($helper->getValue("token"), $helper->getValue("_password_plain"))) {
					$this->get("flash_bag")->add("Reset successful", "Your password has been changed.", "success");
					$this->get("routing")->redirect("login_get", array());
					return;
				} else {
					$this->get("flash_bag")->add("An error occurred", "Please try again later.", "error");
				}
			}
		}
		$this->get("templating")->render("form_reset_password.html.php", array(
			"form" => $helper,
			"token" => $helper->getValue("token")
		));
	}
}