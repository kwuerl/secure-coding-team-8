<?php
namespace Service;

/**
 * This Service is used for anything which has to do with Account
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */
use Model\AccountRepository;

class AccountService {
	private $repository;
	/**
	 * Constructor
	 */
	function __construct(AccountRepository $repository) {
		$this->repository = $repository;
	}
	/**
	 * Returns a randomly generated account ID
	 *
	 * @param id $customer_id    The customer id to generate the account ID for
	 *
	 * @return integer $account_id Randomly generated Account ID.
	 */
	public function generateAccount($customer_id) {
        do {
            $account_id = ACCOUNT_ID_PREFIX + $customer_id;
        } while ($this->repository->findOne(array("account_id" => $account_id)));
        return $account_id;
	}
}