<?php
namespace Helper;

use Service\FlashBagService;
/**
 * TemplatingFormExtension can be used to secure forms
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class TemplatingFlashBagExtension extends TemplatingHelperExtension {
	private $flash_bag_service;
	/**
	 * Constructor
	 */
	function __construct(FlashBagService $flash_bag_service) {
		$this->flash_bag_service = $flash_bag_service;
	}
	/**
	 * Inherited
	 */
	public function getMethodNames() {
		return array(
			"flash_messages" => array($this, "getFlashMessages"),
			"flash_echo" => array($this, "echoFlashMessages"),
		);
	}
	/**
	 * Returns all FLashMessages
	 *
	 * @param TemplatingHelper $t
	 */
	public function getFlashMessages($t) {
		return $this->flash_bag_service->getAll();
	}
	/**
	 * Returns all FLashMessages
	 *
	 * @param TemplatingHelper $t
	 */
	public function echoFlashMessages($t) {
		$messages = $this->getFlashMessages($t);
		foreach ($messages as $message) {
			$html_class = "";
			$html_icon_class = "";
			switch ($message->getType()) {
				case 'error':
					$html_class = "alert-danger";
					$html_icon_class = "fa-ban";
					break;
				case 'success':
					$html_class = "alert-success";
					$html_icon_class = "fa-check";
					break;
				case 'warning':
					$html_class = "alert-warning";
					$html_icon_class = "fa-warning";
					break;
				default:
					$html_class = "alert-info";
					$html_icon_class = "fa-info";
					break;
			}
			echo '<div class="alert '.$html_class.' alert-dismissable">';
	        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	        echo '<h4><i class="icon fa '.$html_icon_class.'"></i> '.$message->getHeadline().'</h4>';
	        echo $message->getMessage();
	        echo '</div>';
        }
	}
}