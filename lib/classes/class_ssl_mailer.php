<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class SSLMailer - Generates the correct request to send mail via the ssl protocol
 *
 * @author Andrey Mishchenko
 * @since 1.0.0
 * @package muse.sender
 */
class SSLMailer {

	/**
	 * Sending the Email
	 *
	 * @author Andrey Mishchenko
	 * @since 1.0.0
	 * @param $to
	 * @param $subject
	 * @param $message
	 * @param $headers
	 *
	 * @return mixed
	 */
	public static function mail($to , $subject , $message , $headers) {

		$mail = new PHPMailer;
		$mail->CharSet = 'utf-8';
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = _MAIL_HOST;
		$mail->Port = _MAIL_PORT;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = _MAIL_USER;
		$mail->Password = _MAIL_PASS;
		$mail->setFrom(_MAIL_USER);
		$mail->addAddress($to);
		$mail->Subject = $subject;
		$mail->msgHTML($message);

		return $mail->send();

	}


	/**
	 * Check the script functions
	 *
	 * @author Andrey Mishchenko
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function script_check() {

		$form_process_file = dirname(__FILE__) . '/../../../form_process.php';

		if (file_exists($form_process_file) && ($handler = @fopen($form_process_file, 'r')) ) {

			// Read the original file
			$contents = fread($handler, filesize($form_process_file));
			fclose($handler);

			// Need to update flag.
			$need_update = false;

			// Check the include instruction
			$code = "require_once(dirname(__FILE__).'/muse.sender/lib/common.php');";
			if (mb_stripos($contents, $code) == false) {
				$need_update = true;
				$contents = "<?php $code ?>" . $contents;
			}

			// Check the send email instruction
			$original_code = '$sent = @mail($to, $subject, $message, $headers);';
			$code = '$sent = SSLMailer::mail($to, $subject, $message, $headers);';
			if (mb_stripos($contents, $original_code) !== false) {
				$contents = str_replace($original_code, $code, $contents);
				$need_update = true;
			}

			// Update the form process file
			if ( $need_update && ($handler = @fopen($form_process_file, 'w')) ) {
				fwrite($handler, $contents);
				fclose($handler);
			}

		}

	}

}