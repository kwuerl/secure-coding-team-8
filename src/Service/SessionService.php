<?php
namespace Service;
/**
 * SessionService is used to abstract the Session functionality of PHP
 *
 * Inspired by http://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class SessionService {
	private static $session_lock = array();
	private $random_service;
	/**
	 * Constructor - Initializes or reinitializes a bulletproof Session
	 * 
	 * @param string $name 	The name of the Session
	 * @param int $limit 	The lifetime of the Session Cookie
	 * @param string $path 	The domain path where the session is active
	 * @param string $domain The domain where the session is active
	 * @param boolean $secure Only set the Session Cookie via https
	 */
	function __construct(RandomService $random_service, $name="Main", $limit = 0, $path = '/', $domain = null, $secure = null) {
		$this->random_service = $random_service;
		// Prevent a session from beeing initialized twice
		if(in_array($name, self::$session_lock)) throw new \Exception("Session with '$name' cannot be started twice!");
		self::$session_lock[] = $name;

		// Set the cookie name
		session_name($name . '_session');

		// Set SSL level
		$https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);

		// Set session cookie options
		session_set_cookie_params($limit, $path, $domain, $https, true);
		session_start();

		// Make sure the session hasn't expired, and destroy it if it has
		if($this->validate())
		{
			// Check to see if the session is new or a hijacking attempt
			if(!$this->preventHijacking())
			{
				// Reset session data and regenerate id
				$this->clear();
				$this->regenerate();

			// Give a 5% chance of the session id changing on any request
			} else if (rand(1, 100) <= 5){
				$this->regenerate();
			}
		} else {
			// reset the session
			$this->reset();
		}
	}
	/**
	 * Validates if the current Session is not obsolete nor expired
	 *
	 * @return boolean
	 */
	private function validate()
	{
		if(isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']) )
			return false;

		if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
			return false;

		return true;
	}
	/**
	 * Regenerates the Session Ajax-save
	 */
	private function regenerate()
	{
		// If this session is obsolete it means there already is a new id
		if(isset($_SESSION['OBSOLETE']) || $_SESSION['OBSOLETE'] == true)
			return;

		// Set current session to expire in 10 seconds. This whole technique is to allow queues request to finish with the old session
		$_SESSION['OBSOLETE'] = true;
		$_SESSION['EXPIRES'] = time() + 10;

		// Create new session without destroying the old one
		session_regenerate_id(false);

		// Grab current session ID and close both sessions to allow other scripts to use them
		$newSession = session_id();
		session_write_close();

		// Set session ID to the new one, and start it back up again
		session_id($newSession);
		session_start();

		// Now we unset the obsolete and expiration values for the session we want to keep
		unset($_SESSION['OBSOLETE']);
		unset($_SESSION['EXPIRES']);
	}
	/**
	 * Initializes or reinitializes a bulletproof Session
	 *
	 * @return boolean
	 */
	private function preventHijacking()
	{
		if(!isset($_SESSION['ipaddress']) || !isset($_SESSION['useragent']))
			return false;

		if ($_SESSION['ipaddress'] != $_SERVER['REMOTE_ADDR'])
			return false;

		if( $_SESSION['useragent'] != $_SERVER['HTTP_USER_AGENT'])
			return false;

		return true;
	}
	/**
	 * Initializes Session Data
	 */
	private function init() {
		$_SESSION['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['csrf_tokens'] = array();
	}
	/**
	 * Resets the Session completely
	 */
	public function reset() {
		$_SESSION = array();
		session_destroy();
		session_start();
		$this->init();
	}
	/**
	 * Clears the Session data
	 */
	public function clear() {
		$_SESSION = array();
		$this->init();
	}

	/**
	 * Sets a session parameter
	 *
	 * @param string $name							Name of the parameter
	 * @param string|integer|float|array $value		Value of the parameter
	 */
	public function set($name, $value) {
		//TODO: further checks
		$_SESSION[$name] = $value;
	}
	/**
	 * Gets a session parameter
	 *
	 * @param string $name		Name of the parameter
	 *
	 * @return string
	 */
	public function get($name) {
		if(!isset($_SESSION[$name])) throw new Exception("Session parameter '$name' not found! Use has() before get()!");
		return $_SESSION[$name];
	}
	/**
	 * Checks if a session parameter is set.
	 *
	 * @param string $name		Name of the parameter
	 *
	 * @return string
	 */
	public function has($name) {
		return isset($_SESSION[$name]);
	}	
}