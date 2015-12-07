<?php
namespace Service;
/**
 * Can be used to manage CSRF tokens
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class CSRFService {
	private $session_service;
	private $random_service;
	private $lifetime;
	/**
	 * Constructor
	 */
	function __construct (SessionService $session_service, RandomSequenceGeneratorService $random_service,  $lifetime=0) {
		$this->session_service = $session_service;
		$this->lifetime = $lifetime;
		$this->random_service = $random_service;
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
		$tokens = $this->session_service->get("csrf_tokens");
		if(array_key_exists($context, $tokens)) {
			$tokens[$context]["expires"] = time()+$this->lifetime;
			$this->session_service->set("csrf_tokens", $tokens);
			return $tokens[$context];
		}
		$token_hash = $this->random_service->getHash();
		$key = $this->random_service->getHash();
		$token = array("key"=>$key,"token"=>$token_hash, "expires"=>time()+$this->lifetime);
		$tokens[$context] = $token;
		$this->session_service->set("csrf_tokens", $tokens);
		return $token;
	}
	/**
	 * Creates a new CSRF Token which is saved within the Session
	 *
	 * @param string $context		Name of the Token
	 *
	 * @return string
	 */
	public function getContextKey($context) {
		$tokens = $this->session_service->get("csrf_tokens");
		if(array_key_exists($context, $tokens)) {
			$token = $tokens[$context];
			return $token["key"];
		}
		return false;
	}
	/**
	 * Checks a CSRF Token
	 *
	 * @param string $context		Name of the Token
	 * @param string $token	 The CSRF Token
	 *
	 * @return boolean
	 */
	public function checkCSRFToken($context, $token) {
		$tokens = $this->session_service->get("csrf_tokens");
		if(array_key_exists($context, $tokens)) {
			$token_n = $tokens[$context];
			if($token_n["token"] == $token) {
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
			if($token["expires"] >= time() || $token["expires"] == 0) {
				$tokens_new[$token_name] = $token;
			}
		}
		$this->session_service->set("csrf_tokens", $tokens_new);
	}
}
