<?php 
namespace Service;

class TemplatingService {
	public function render($template_name, $payload, $echo=true) {
		set_exception_handler(function ($e) {
		    ob_end_clean();
		    echo "Templating Error:<br>";
		    echo $e;
		});
		$render = function ($t) {
			$next_file = $t->getCurrentTemplateName();
			while (isset($next_file)) {
				ob_start();
				include("Template/".$next_file);
				$ret = ob_get_contents();
				ob_end_clean();
				unset($next_file);
				
				if($t->getCurrExtends() != "") {
					$next_file = $t->getCurrExtends();
				}
				$t->__resetCurrExtends();
			}
			return $ret;
		};
		$t = new \Helper\TemplatingHelper($payload);
		$t->__setCurrentTemplateName($template_name);
		
		$ret = $render($t);
		if($echo) {
			echo $ret;
		}
		return $ret;
	}
}