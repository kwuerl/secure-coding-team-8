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

		// create the FormHelper
		$helper = new \Helper\FormHelper("form_login");

		//add one field
		$helper->addField("email", "text", array(
			array("required", "Email is required"),
			array("email", "Please input a valid e-mail")
		), array("ltrim", "rtrim"), "");

		$helper->addField("_password_plain", "text", array(
			array("required", "Password is required")
		), array("ltrim", "rtrim"), "");

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
}