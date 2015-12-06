<?php
namespace Service;
use \Helper\FormHelper;

/**
 * This Service is used to spawn form helpers
 */
class FormService {
	protected $csrf_service;
	/**
	 * Constructor
	 */
	function __construct(CSRFService $csrf_service) {
		$this->csrf_service = $csrf_service;
	}
	/**
	 * Returns a Form Helpeer
	 *
	 * @param string $form_name   The Forms name
	 * @param string $method    The form method
	 *
	 * @return FormHelper
	 */
	public function getCSRFFormHelper($form_name, $method="POST") {
        $helper = new FormHelper($form_name, $method, $this->csrf_service);
        return $helper;
	}
}