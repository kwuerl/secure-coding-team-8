<?php
namespace Controller;

class ExampleController extends Controller {
	public function testFunction ($request, $url_param) {
		$this->get("user_repository");
		$this->get("templating")->render("example.html.php", array(
			"url_param"=>$url_param,
			"fixed_param"=>_EXAMPLE_PARAM
		));
	}

	public function formtest ($request) {
        $this->get("auth")->check(_GROUP_EMPLOYEE);
		// create the FormHelper
		$helper = new \Helper\FormHelper("test_form");

		//add one field
		$helper->addField("test_field", "text", array(
	  		array("required", "Field is required")
		), array("ltrim", "rtrim"), "");

		// try to process the request
		if($helper->processRequest($request)) {

			//try to validate
			if($helper->validate()) {

				// fill the model
				$model = new \Model\Example();
				$helper->fillModel($model);

				// render the model
				$this->get("templating")->render("form_example_success.html.php", array(
					"example" => $model
				));
				return;
			}
		}
		// render the form
		$this->get("templating")->render("form_example.html.php", array(
			"form" => $helper
		));
	}
}