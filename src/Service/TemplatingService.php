<?php 
namespace Service;
/**
 *	TemplatingService can be used to render templates and provides access to a Helper\TemplatingHelper containing the template parameters within the template.
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class TemplatingService {
	private $template_helper_extensions;
	public function addTemplateHelperExtension(\Helper\TemplatingHelperExtension $extension) {
		$template_helper_extensions[] = $extension;
	}
	/**
	 * renders a template either to "echo" or to output
	 *
	 * @param string $template_name 	Name of the template to render relative to the "Template" folder.
	 * @param array $payload 			Payload data that has to be available within the template.
	 * @param boolean $echo=true 		true: Rendered Content will be echoed directly
	 *
	 * @return string
	 */
	public function render($template_name, $payload, $echo=true) {
		// make sure to cancel all output if any Exception occurs.  
		set_exception_handler(function ($e) {
		    ob_end_clean();
		    echo "Templating Error:<br>";
		    echo $e;
		});
		// Prepare the render function. We use a anonymous function to make sure only $t can be accessed.
		$render = function ($t) {
			$next_file = $t->getCurrentTemplateName();
			while ($next_file != "") {
				// start output handling
				ob_start();
				include("Template/".$next_file);
				// redirect all output to $ret
				$ret = ob_get_contents();
				// delete all output
				ob_end_clean();
				//get the next file in the extends chain
				if($t->getCurrExtends() != "") {
					$next_file = $t->getCurrExtends();
				} else {
					$next_file = "";
				}
				//reset the TemplatingHelper
				$t->__resetCurrExtends();
			}
			return $ret;
		};
		$t = new \Helper\TemplatingHelper($payload, $this->template_helper_extensions);
		// Start rendering
		$t->__setCurrentTemplateName($template_name);
		$ret = $render($t);
		// reset exception handlgin
		restore_exception_handler();

		if($echo) {
			echo $ret;
			return true;
		} else {
			return $ret;
		}
		
	}
}