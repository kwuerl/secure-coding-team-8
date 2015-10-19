<?php
namespace Service;
/**
 * RandomService can be used to securely generate a variety of random strings and numbers
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */
class RandomService {
	/**
	 * Returns a random String with length $length
	 *
	 * @param int $length	Length of random string to be created
	 *
	 * @return string
	 */
	public function getString($length) {
	    /*Use random_bytes() if it is defined. Else, use openssl_random_pseudo_bytes*/
	    if (function_exists('random_bytes'))
			$bytes = random_bytes($length);
	    else
			$bytes = openssl_random_pseudo_bytes($length);

		$base64 = base64_encode($bytes);
		return substr($base64, 0, $length);
	}
	/**
	 * Returns a random Hash
	 *
	 * @return string
	 */
	public function getHash() {
		return sha1($this->getString(40));
	}
}