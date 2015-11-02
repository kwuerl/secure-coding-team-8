<?php
namespace Service;

use Model\TransactionCode;
use Model\TransactionCodeRepository;
/**
 * This Service is used for anything which has to do with Transaction
 */
class TransactionService {
	private $repository;
	private $random;
	/**
	 * Constructor
	 */
	function __construct(TransactionCodeRepository $repository, RandomSequenceGeneratorService $random) {
		$this->repository = $repository;
		$this->random = $random;
	}
	/**
	 * Returns an array with 100 unique transaction codes
	 *
	 * @param id $customer_id    The customer id to generate the set for
	 *
	 * @return array    Array with TransactionCode models
	 */
	public function generateTransactionCodeSet($customer_id) {
		$set = array();
		for ($i = 0; $i < 100; $i++) {
			do {
				$code = $this->random->getString(15);
			} while (in_array($code, $set) && $this->repository->findOne(array("code" => $code)));
			$code_instance = new TransactionCode();
			$code_instance->setCustomerId($customer_id);
			$code_instance->setCode($code);
			$code_instance->setIsUsed(false);
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
			if (!$db_result->getIsUsed()) {
				return true;
			}
		}
		return false;
	}
}