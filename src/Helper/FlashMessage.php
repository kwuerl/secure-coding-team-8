<?php
namespace Helper;

/**
 * This class represents a flash message that can be used with the FlashBagService
 */
class FlashMessage {
	private $headline;
	private $type;
	private $message;
	/**
	 * Constructor
	 */
	function __construct($headline, $message="", $type="info") {
		$this->headline = $headline;
		$this->type = $type;
		$this->message = $message;
	}
	/**
	 * Gets the headline
	 *
	 * @return string
	 */
	public function getHeadline() {
		return $this->headline;
	}
	/**
	 * Sets the headline
	 *
	 * @param string $headline
	 */
	public function setHeadline($headline) {
		$this->headline = $headline;
	}
	/**
	 * Gets the type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	/**
	 * Sets the type
	 *
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	/**
	 * Gets the message
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}
	/**
	 * Sets the message
	 *
	 * @param string $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}
}