<?php
namespace Service;

use Model\TransactionCode;
use Model\TransactionCodeRepository;
/**
 * This Service can be used to generate a set of 100 transaction codes.
 */
class TransactionCodeGeneratorService {
	private $repository;
	/**
	 * Constructor
	 */
	function __construct(TransactionCodeRepository $repository) {
		$this->repository = $repository;
	}
	/**
	 * Returns an array with 100 unique transaction codes
	 *
	 * @param id $customer_id    The customer id to generate the set for
	 *
	 * @return array    Array with TransactionCode models
	 */
	public function generateSet($customer_id) {
		$set = array();
		for ($i = 0; $i < 100; $i++) {
			do {
				$code = RandomSequenceGeneratorService::getString(15);
			} while (in_array($code, $set) && $this->repository->findOne(array("code" => $code)));
			$code_instance = new TransactionCode();
			$code_instance->setCustomerId($customer_id);
			$code_instance->setCode($code);
			$code_instance->setUsed(false);
			$this->repository->add($code_instance);
			$set[] = $code_instance;
		}
		if (sizeof($set) == 100) {
			return $set;
		} else {
			throw new \Exception("There was an error with generating a set of transaction codes.");
		}
	}
	/**
	 * Checks if the transaction code $code is valid
	 *
	 * @param int $customer_id    The customer id
	 * @param string $code    The code to check
	 *
	 * @return boolean    Returns true, if code is valid and not used for that customer, otherwise returns false
	 */
	public function checkCode($customer_id, $code) {
		$db_result = $this->repository->findOne(array("customer_id" => $customer_id, "code" => $code));
		if ($db_result) {
			if (!$db_result->getUsed()) {
				return true;
			}
		}
		return false;
	}
}