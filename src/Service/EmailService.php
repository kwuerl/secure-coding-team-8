<?php
namespace Service;

/**
 * This Service can be used to send e-mails
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */
class EmailService {
	private $sender_email = "";
	/**
	 * Constructor
	 */
	function __construct($sender_email) {
		$this->sender_email = $sender_email;
	}
	/**
	 * Sends an e-mail to $recipient with $subject
	 *
	 * @param string $recipient
	 * @param string $subject
	 * @param string $msg
	 *
	 * @return boolean
	 */
	public function sendMail($recipient, $subject, $msg) {
		if (\Helper\ValidationHelper::email(new \Helper\FormHelper("helper"), $recipient)) {
			$header = "MIME-Version: 1.0\r\n";
		    $header .= "Content-type: text/html; charset=utf-8\r\n";
		    $header .= "From: ".$this->sender_email."\r\n";
		    $header .= "Reply-To: ".$this->sender_email."\r\n";
		    $header .= "X-Mailer: PHP ". phpversion();

			if (mail($recipient, $subject, $msg, $header)) {
				return true;
			}
		} else {
			throw new \Exception("'$recipient' is not a valid e-mail address!");
		}
		return false;
	}
}