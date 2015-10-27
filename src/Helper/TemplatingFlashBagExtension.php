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
		foreach($messages as $message) {
			if($message->getType() == "error") {
				echo '<div class="alert alert-danger alert-dismissable">';
			} else if($message->getType() == "success") {
				echo '<div class="alert alert-success alert-dismissable">';
			} else if($message->getType() == "warning") {
				echo '<div class="alert alert-warning alert-dismissable">';
			} else {
				echo '<div class="alert alert-info alert-dismissable">';
			}
	          echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	          echo '<h4><i class="icon fa fa-ban"></i> '.$message->getHeadline().'</h4>';
	          echo $message->getMessage();
	        echo '</div>';
        }
	}
}