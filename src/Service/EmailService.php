<?php
namespace Service;

/**
 * This Service can be used to send e-mails
 *
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 * @author Vivek Sethia<vivek.sethia@tum.de>
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
		    $header .= "From: Secure Bank <".$this->sender_email.">\r\n";
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
	
    /**
	 * Sends an e-mail to $recipient with subject, msg and an attachment
	 *
	 * @param string $recipient
	 * @param string $subject
	 * @param string $msg
	 * @param $attachment
	 * @param string $attachmentName
	 *
	 * @return boolean
	 */
	public function sendMailWithAttachment($recipient, $subject, $msg, $attachment, $attachmentName) {
		if (\Helper\ValidationHelper::email(new \Helper\FormHelper("helper"), $recipient)) {
		     // a random hash will be necessary to send mixed content
			$separator = md5(time());
			// carriage return type (we use a PHP end of line constant)
			$eol = PHP_EOL;
		    
		    // main header (multipart mandatory)
			$headers = "From: Secure Bank < ".$this->sender_email.">".$eol;
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
			$headers .= "Content-Transfer-Encoding: 7bit".$eol;
			$headers .= "This is a MIME encoded message.".$eol.$eol;
			// message
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$headers .= $msg.$eol.$eol;
			// attachment
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: application/octet-stream; name=\"".$attachmentName."\"".$eol;
			$headers .= "Content-Transfer-Encoding: base64".$eol;
			$headers .= "Content-Disposition: attachment".$eol.$eol;
			$headers .= $attachment.$eol.$eol;
			$headers .= "--".$separator."--";

			if (mail($recipient, $subject, $msg, $headers)) {
				return true;
			}
		} else {
			throw new \Exception("'$recipient' is not a valid e-mail address!");
		}
		return false;
	}
}