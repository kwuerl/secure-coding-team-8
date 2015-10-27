<?php
namespace Service;

use \Helper\FlashMessage;

/**
 * This Service can be used to store and display flash messages 
 */
class FlashBagService {
	private $session_var_name = "flash_bags";
	private $session_service;
	/**
	 * Contructor
	 */
	function __construct (SessionService $session_service) {
		$this->session_service = $session_service;
		$this->init();
	}
	/**
	 * Inits the FlashBag Session variable
	 */
	private function init() {
		if(!$this->session_service->has($this->session_var_name)) {
			$this->session_service->set($this->session_var_name, array());
		}
	}
	/**
	 * Adds a message to the FlashBag
	 *
	 * @param string $headline 
	 * @param string $message 
	 * @param string $ype 
	 */
	public function add($headline, $message="", $ype="info") {
		$message = new FlashMessage($headline, $message, $ype);
		$this->addMessage($message);
	}
	/**
	 * Adds a message to the FlashBag
	 *
	 * @param FlashMessage $message 
	 */
	public function addMessage(FlashMessage $message) {
		$this->init();
		$bag = $this->session_service->get($this->session_var_name);
		$bag[] = $message;
		$this->session_service->set($this->session_var_name, $bag);
	}
	/**
	 * Adds a message to the FlashBag
	 *
	 * @param FlashMessage $message 
	 */
	public function clear() {
		$this->session_service->set($this->session_var_name, array());
	}
	/**
	 * Adds a message to the FlashBag
	 *
	 * @return array all Flash messages
	 */
	public function getAll() {
		$this->init();
		$ret = $this->session_service->get($this->session_var_name);
		$this->clear();
		return $ret;
	}
}