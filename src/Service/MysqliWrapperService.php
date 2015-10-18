<?php
namespace Service;
/**
 * Just wraps Mysqli for usage with the ServiceContainer
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class MysqliWrapperService {
	private $mysqli;
	/**
	 * Constructor
	 */
	function __construct ($host, $user) {
		//TODO
		$mysqli = "TODO";
	}
	/**
	 * Returns the Mysqli instance
	 *
	 * @return \Mysqli
	 */
	public function get() {
		return $mysqli;
	}

}
