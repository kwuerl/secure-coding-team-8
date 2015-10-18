<?php
namespace Service;
/**
 * Can be used to manage CSRF tokens
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class CSRFService {
	private $session_service;
	private $lifetime;
	/**
	 * Constructor
	 */
	function __construct (SessionService $session_service, $lifetime=0) {
		$this->session_service = $session_service;
		$this->lifetime = $lifetime;

		// Validate all CSRF tokens and throw out the expired ones
		$this->validateCSRF();
	}
	/**
	 * Creates a new CSRF Token which is saved within the Session
	 *
	 * @param string $context		Name of the Token
	 *
	 * @return string
	 */
	public function createCSRFToken($context) {
		$token = $this->random_service->getHash();
		$tokens = $this->session_service->get("csrf_tokens");
		$tokens[$context] = array("token"=>$token, "expires"=>time()+$this->lifetime);
		$this->session_service->set("csrf_tokens", $tokens);
		return $token;
	}
	/**
	 * Checks a CSRF Token and deletes it out of the session
	 *
	 * @param string $context		Name of the Token
	 * @param string $token	 The CSRF Token
	 *
	 * @return boolean
	 */
	public function checkCSRFToken($context, $token) {
		$tokens = $this->session_service->get("csrf_tokens");
		if(in_array($context, $tokens)) {
			$token = $tokens[$context];
			if($token["token"] == $token) {
				unset($tokens[$context]);
				return true;
			}
		}
		return false;
	}
	/**
	 * Validates all CSRFTokens and deletes expired ones;
	 */
	private function validateCSRF() {
		if(!$this->session_service->has("csrf_tokens")) $this->session_service->set("csrf_tokens", array());
		if($this->lifetime == 0) return;
		$tokens = $this->session_service->get("csrf_tokens");
		$tokens_new = array();
		foreach ($tokens as $token_name=>$token) {
			if($token["expires"] >= time()) {
				$tokens_new[$token_name] = $token;
			}
		}
		$this->session_service->set("csrf_tokens", $tokens_new);
	}
}
