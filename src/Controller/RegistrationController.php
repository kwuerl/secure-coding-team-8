<?php
namespace Controller;

/**
 * Registration Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class RegistrationController extends Controller {

	public function processRegistration($request) {
		// create the FormHelper
		$helper = new \Helper\FormHelper("form_registration");

		//add one field
		$helper->addField("first_name", "name", array(
			array("required", "First name is required"),
			array("name", "Only letters, '-' and white space allowed and must be at least 2 characters")
		), array("ltrim", "rtrim"), "");

		$helper->addField("last_name", "name", array(
			array("required", "Last name is required"),
			array("name", "Only letters, '-' and white space allowed and must be at least 2 characters")
		), array("ltrim", "rtrim"), "");

		$helper->addField("email", "email", array(
			array("required", "E-Mail is required"),
			array("email", "Please input a valid e-mail")
		), array("ltrim", "rtrim"), "");

		$helper->addField("_password_plain", "password", array(
			array("required", "Password is required"),
			array("password", "Only letters, numbers and '-_$^?\+#' allowed")
		), array("ltrim", "rtrim"), "");

		$helper->addField("password_repeat", "password", array(
			array("required", "Please repeat your password"),
			array("password", "Only letters, numbers and '-_$^?\+#' allowed"),
			array("equal", "Passwords do not match", array("_password_plain"))
		), array("ltrim", "rtrim"), "");

		// try to process the request
		if ($helper->processRequest($request)) {

			//try to validate
			if ($helper->validate()) {

				// fill the model
				$model = new \Model\User();
				$helper->fillModel($model);

				$model->setGroups(array(_GROUP_USER));

				// if customer with email doesn't exist, add to repository
				if (!$this->get('customer_repository')->findOne(array("email" => $model->getEmail()))) {
					// add to repository
					if ($this->get('customer_repository')->add($model)) {
						$this->get("flash_bag")->add("Thank you for your registration!", "You will receive an e-mail with further information soon.", "success");
						$this->get("routing")->redirect("login_get", array());
						return;
					} else {
						$this->get("flash_bag")->add("Registration failed!", "Please try again later.", "error");
					}
				} else {
					$this->get("flash_bag")->add("Registration failed!", "There is already an account with this e-mail.", "error");
				}
			}
		}
		// render the form
		$this->get("templating")->render("form_registration.html.php", array(
			"form" => $helper
		));
	}
}