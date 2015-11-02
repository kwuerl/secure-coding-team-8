<?php
namespace Controller;

class DefaultController extends Controller {
	public function landingFunction ($request) {
		$this->get("templating")->render("landing.html.php", array(
		));
	}
}