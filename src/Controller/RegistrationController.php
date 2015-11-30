<?php
namespace Controller;

/**
 * Registration Controller class that extends Controller. Gets ServiceContainer injected.
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class RegistrationController extends Controller {
	/**
	 * This function is for the registration process of a customer.
	 *
	 * @param Request $request
	 */
	public function processRegistration($request) {
		if($this->get("auth")->redirectCurrentUserToUserHome()) return;
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

		$helper->addField("address", "text", array(
			array("required", "Address is required"),
			array("maxLength", "Max. 60 characters allowed", array(60)),
			array("address", "Please input a valid address, e.g. Example St. 1a")
		), array("ltrim", "rtrim"), "");

		$helper->addField("postal_code", "text", array(
			array("required", "Postal code is required"),
			array("number", "Only numbers are allowed"),
			array("maxLength", "Max. 5 numbers allowed", array(5))
		), array("ltrim", "rtrim"), "");

		$helper->addField("city", "text", array(
			array("required", "City is required"),
			array("maxLength", "Max. 20 characters allowed", array(20))
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
				$model = new \Model\Customer();
				$helper->fillModel($model);

				$model->setGroups(array(_GROUP_USER));
				$model->setRegistrationDate(date("Y-m-d H:i:s"));

				// encrypt password and save it
				$salt = $this->get("random")->getString(16);
				$model->setSalt($salt);
				$model->setPassword(crypt($model->getPasswordPlain(), $salt));

				// if customer with email doesn't exist, add to repository
				if (!$this->get('customer_repository')->findOne(array("email" => $model->getEmail()))) {

					// add to repository
					if ($this->get('customer_repository')->add($model)) {

						// send confirmation email
						$this->get("email")->sendMail(
							$model->getEmail(),
							"Thank you for your registration",
							"Dear ".$model->getFirstName()." ".$model->getLastName().",\nthank you for your registration at SecureBank.\nAs soon as our employees have checked your registration, you will get another e-mail containing further information on how to proceed.\n\nHave a nice day,\nyour SecureBank"
						);

						// set flash message and redirect
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
	/**
	 * This function is for the registration process of an employee.
	 *
	 * @param Request $request
	 */
	public function processEmployeeRegistration($request) {
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
				$model = new \Model\Employee();
				$helper->fillModel($model);

				$model->setGroups(array(_GROUP_EMPLOYEE));
				$model->setRegistrationDate(date("Y-m-d H:i:s"));
				$model->setIsActive(0);
				$model->setIsAuthorized(0);
				$model->setIsClosed(0);
				$model->setIsRejected(0);

				// encrypt password and save it
				$salt = $this->get("random")->getString(16);
				$model->setSalt($salt);
				$model->setPassword(crypt($model->getPasswordPlain(), $salt));

				// if customer with email doesn't exist, add to repository
				if (!$this->get('employee_repository')->findOne(array("email" => $model->getEmail()))) {

					// add to repository
					if ($this->get('employee_repository')->add($model)) {

						// send confirmation email
						$this->get("email")->sendMail(
							$model->getEmail(),
							"Thank you for your application",
							"Dear ".$model->getFirstName()." ".$model->getLastName().",\nthank you for your application for a job at SecureBank.\nWe will look into your application as soon as possible and we will get back to you.\n\nHave a nice day,\nyour SecureBank"
						);

						// set flash message and redirect
						$this->get("flash_bag")->add("Thank you for your application!", "We will look into your application soon and we will get back to you.", "success");
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
		$this->get("templating")->render("form_registration_employee.html.php", array(
			"form" => $helper
		));
	}
}