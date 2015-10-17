<?php
namespace Controller;

class ExampleController extends Controller {
	public function testFunction ($request, $url_param) {
		$this->get("templating")->render("example.html.php", array(
			"url_param"=>$url_param, 
			"fixed_param"=>$this->get("param")->get("example_param")
		));
	}
}