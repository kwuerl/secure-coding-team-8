<?php
namespace Service;
/**
 * RandomService can be used to securely generate a viarity of random strings and numbers
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
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
		$bytes = openssl_random_pseudo_bytes($length);
    	$base64   = base64_encode($bytes);
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