<?php
namespace Controller;

class ExampleController extends Controller {
	public function testFunction ($request, $url_param) {
		$this->get("templating")->render("example.html.php", array(
			"url_param"=>$url_param, 
			"fixed_param"=>$this->get("param")->get("example_param")
		));
	}

	public function formtest ($request) {
		$helper = new \Helper\FormHelper("test_form");
		$helper->addField("test_field", "text", array(
	  		array("required", "Field is required")
		), array("ltrim", "rtrim"), "");
		if($helper->processRequest($request)) {
			if($helper->validate()) {
				$model = new \Model\Example();
				$helper->fillModel($model);
				$this->get("templating")->render("form_example_success.html.php", array(
					"example" => $model
				));
				return;
			}
		}
		$this->get("templating")->render("form_example.html.php", array(
			"form" => $helper
		));
	}
}