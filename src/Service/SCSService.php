<?php
namespace Service;

use Model\SCS;
use Model\SCSRepository;
/**
 * This Service is used to provide SCS-related services
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 *
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
	/**
     * Returns the scs pin for the specified customer
     *
     * @param int $customer_id    The customer id
     *
     * @return string|boolean    Returns the pin for the specified customer, if found and false otherwise
     */
    public function getPin($customer_id) {
        $db_result = $this->repository->findOne(array("customer_id" => $customer_id));
        if ($db_result) {
            return $db_result->getPin();
        }
        return false;
    }
    /**
     * Generates a TAN code based on the input string provided
     *
     * @param string $input            Input string
     *
     * @return string  Returns the generated TAN code
     */
    public function generateTan($input) {
        $input = preg_replace('/\s+/', '', $input);
        $utf = utf8_encode($input.strval(round(time()/100)));
        $hash = hash("sha512", $utf);
        return substr($hash, 0, 15);
    }
}