<?php
namespace Service;

use Model\TransactionCode;
use Model\TransactionCodeRepository;
/**
 * This Service is used for anything which has to do with Transaction
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 *
 */
class TransactionCodeService {
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
	 * @return array|boolean    Returns array with TransactionCode models or false if there was an error
	 */
	public function generateTransactionCodeSet($customer_id) {
		$set = array();
		$this->repository->beginDBTransaction();
		$success = false;
		for ($i = 0; $i < 100; $i++) {
			do {
				$code = $this->random->getString(15);
			} while (in_array($code, $set) && $this->repository->findOne(array("code" => $code)));
			$code_instance = new TransactionCode();
			$code_instance->setCustomerId($customer_id);
			$code_instance->setCode($code);
			$code_instance->setIsUsed(false);
			if ($this->repository->add($code_instance)) {
				$success = true;
			} else {
				$success = false;
			}
			$set[] = $code_instance;
		}
		if ($success == true && sizeof($set) == 100) {
			$this->repository->commitDB();
			return $set;
		} else {
			$this->repository->rollBackDB();
			throw new \Exception("There was an error with generating a set of transaction codes.");
			return false;
		}
	}
	/**
	 * Checks if the transaction code $code is pristine i.e., unused
	 *
	 * @param int $customer_id    The customer id
	 * @param string $code    The code to check
	 *
	 * @return boolean    Returns the transaction code model, if code is unused for that customer, otherwise returns false
	 */
	public function isCodePristine($customer_id, $code) {
		$db_result = $this->repository->findOne(array("customer_id" => $customer_id, "code" => $code, "is_used" => 0));
		if ($db_result) {
			return $db_result;
		}
		return false;
	}
	/**
	 * Checks if the transaction code $code exists
	 *
	 * @param string $code    The code to check
	 *
	 * @return boolean    Returns the transaction code model, if code exists, otherwise returns false
	 */
	public function isCodeExists($code) {
		$db_result = $this->repository->findOne(array("code" => $code));
		if ($db_result) {
			return $db_result;
		}
		return false;
	}
}