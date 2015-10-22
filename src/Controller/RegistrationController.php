<?php
namespace Controller;

/**
 * Registration Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class RegistrationController extends Controller {

	public function processRegistration ($request) {
		// create the FormHelper
		$helper = new \Helper\FormHelper("form_registration");

		//add one field
		$helper->addField("first_name", "text", array(
			array("required", "First name is required")
		), array("ltrim", "rtrim"), "");

		$helper->addField("last_name", "text", array(
			array("required", "Last name is required")
		), array("ltrim", "rtrim"), "");

		$helper->addField("email", "email", array(
			array("required", "E-Mail is required")
		), array("ltrim", "rtrim"), "");

		$helper->addField("password", "text", array(
			array("required", "Password is required")
		), array("ltrim", "rtrim"), "");

		// try to process the request
		if($helper->processRequest($request)) {

			//try to validate
			if($helper->validate()) {

				// fill the model
				$model = new \Model\Registration();
				$helper->fillModel($model);

				// render the model
				$this->get("templating")->render("form_registration_success.html.php", array(
					"registration" => $model
				));
				return;
			}
		}
		// render the form
		$this->get("templating")->render("form_registration.html.php", array(
			"form" => $helper
		));
	}
}