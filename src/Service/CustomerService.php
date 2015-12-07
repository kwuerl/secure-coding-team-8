<?php
namespace Service;

use \Model\AccountRepository;
use \Model\CustomerRepository;

/**
 * This Service is used for anything which has to do with Customer
 */

class CustomerService {
	private $account_repository;
    private $customer_repository;
	private $account;
	private $transaction_code;
	private $pdf;
	private $email;
	private $scs;
	/**
	 * Constructor
	 */
	function __construct(
		AccountRepository $account_repository, 
        CustomerRepository $customer_repository,
		AccountService $account, 
		TransactionCodeService $transaction_code,
		PdfService $pdf,
		EmailService $email,
		SCSService $scs
    ) {
		$this->account_repository = $account_repository;
        $this->customer_repository = $customer_repository;
		$this->account = $account;
		$this->transaction_code = $transaction_code;
		$this->pdf = $pdf;
		$this->email = $email;
		$this->scs = $scs;
	}
	/**
	 * Initializes a customer Account
	 *
	 * @param Customer $user_model    The customer to initialize
	 *
	 * @throws Exception
	 */
	public function initialize($user_model) {

        // fill the model
        $account_model = new \Model\Account();
        $account_id = $this->account->generateAccount($user_model->getId());

        $account_model->setAccountId($account_id);
        $account_model->setCustomerId($user_model->getId());
        $account_model->setType("SAVINGS");
        $account_model->setIsActive(1);
        $tan_method = $user_model->getTanMethod();

        if($this->customer_repository->actOnRegistration($user_model, _ACTION_APPROVE, $this->account_repository, $account_model) == false) {
        	throw new \Exception("Customer could not be approved");
        }

        if($tan_method == _TAN_METHOD_EMAIL) {
            // send email with transaction codes
            $tans = $this->transaction_code->generateTransactionCodeSet($user_model->getId());

            if ($tans) {
                $pdf_password = trim(substr($user_model->getLastName(), 0, 2)) . trim(substr($account_id, -4)) . trim(substr($user_model->getFirstName(), 0, 2));
                $pdf_password_length = strlen($pdf_password);
                if ($pdf_password_length < 8) {
                    $pdf_password .= str_repeat('x', (8 - $pdf_password_length));
                }

                $this->sendTanEmail($user_model, $tans, $pdf_password);
                
            } else {
                // TODO: rollback of customer approval and account generation if transaction code generation failed
                throw new \Exception("There was an error with generating the transaction codes.");
            }
        } else {

            $scs_pin = $this->scs->generateSCSPin($user_model->getId());
            // sends email after SCS Pin generation
            if($scs_pin) {
            	$this->sendScsEmail($user_model, $scs_pin);
            } else {
                throw new \Exception("There was an error in generating SCS pin.");
            }
        }
	}
	/**
	 * Sends the tan email
	 *
	 * @param Customer $user_model    The customer
	 * @param array $tans    The tan array
	 * @param string $pdf_password    The pdf password
	 *
	 * @throws Exception
	 */
	private function sendTanEmail($user_model, $tans, $pdf_password) {
		$attachment = $this->pdf->generatePdfWithTans($tans, $pdf_password);
        $subject = "Your registration at SecureBank was successful!";
        $email_msg = "Dear ".$user_model->getFirstName()."&nbsp;".$user_model->getLastName().",<br/><br/>".
                      "Your registration was approved.<br/>".
                      "Kindly find the attachment with the TANs. Note that the document is password protected.<br/>".
                      "The password is formed by the first two characters of your last name, last four characters of your account number and the first two characters of your first name.<br/>".
                      "Please do not share TANs with anyone.";
        $attachmentName = time() . "_TAN.pdf";
        $this->email->sendMailWithAttachment(
            $user_model->getEmail(),
            $subject,
            $email_msg,
            $attachment,
            $attachmentName
        );
	}
	/**
	 * sends the scs email
	 *
	 * @param Customer $user_model    The customer
	 * @param string $scs_pin    The scs pin
	 *
	 * @throws Exception
	 */
	private function sendScsEmail($user_model, $scs_pin) {
		$subject = "Your registration at SecureBank was successful!";
        $email_msg = "Dear ".$user_model->getFirstName()."&nbsp;".$user_model->getLastName().",<br/><br/>".
                      "Your registration was approved.<br/>".
                      "The pin for your Smart Card Simulator is ".$scs_pin."<br/>".
                      "To use the Smart Card Simulator, follow the below steps.<br/>".
                      "1. Login to the bank and download the \"SCS\".<br/>".
                      "2. Extract the downloaded file to get SecureBank-SCS.jar.<br/>".
                      "3. If you are a Windows user, double click on the .jar file to run the application. If you are a Linux user, use the command \"java -jar SecureBank-SCS.jar\".<br/>".
                      "The SCS is now ready to be used.<br/>".
                      "Please do not share the SCS pin with anyone.";
        $this->email->sendMail(
            $user_model->getEmail(),
            $subject,
            $email_msg
        );
	}
}