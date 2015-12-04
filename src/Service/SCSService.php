<?php
namespace Service;

use Model\SCS;
use Model\SCSRepository;
/**
 * This Service is used to provide SCS-related services
 */
class SCSService {
	private $repository;
	private $random;
	/**
	 * Constructor
	 */
	function __construct(SCSRepository $repository, RandomSequenceGeneratorService $random) {
		$this->repository = $repository;
		$this->random = $random;
	}
	/**
	 * Returns the unique SCS pin
	 *
	 * @param id $customer_id    The customer id to generate the SCS pin for
	 *
	 * @return string|boolean    Returns SCS pin or false if there was an error
	 */
	public function generateSCSPin($customer_id) {
        do {
            $scs_pin = $this->random->getString(6);
        } while ($this->repository->findOne(array("pin" => $scs_pin)));

        $success = false;

        $scs_instance = new SCS();
        $scs_instance->setCustomerId($customer_id);
        $scs_instance->setPin($scs_pin);
        if ($this->repository->add($scs_instance)) {
            return $scs_pin;
        }
        return false;
	}
}