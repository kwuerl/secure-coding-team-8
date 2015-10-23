<?php
namespace Controller;

/**
 * Login Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
class LoginController extends Controller {

	public function processLogin ($request) {
		// create the FormHelper
		$helper = new \Helper\FormHelper("form_login");

		//add one field
		$helper->addField("email", "text", array(
			array("required", "Email is required")
		), array("ltrim", "rtrim"), "");

		$helper->addField("password", "text", array(
			array("required", "Password is required")
		), array("ltrim", "rtrim"), "");

		// try to process the request
		if($helper->processRequest($request)) {

			//try to validate
			if($helper->validate()) {

				// fill the model
				$model = new \Model\Login();
				$helper->fillModel($model);

				// render the model
				$this->get("templating")->render("form_login_success.html.php", array(
					"login" => $model
				));
				return;
			}
		}
		// render the form
		$this->get("templating")->render("form_login.html.php", array(
			"form" => $helper
		));
	}
}