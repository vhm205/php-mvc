<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	function sendMail($email, $password, $to, $subject, $body)
	{
		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
		    $mail->isSMTP(); // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';  // Set the SMTP server to send through
		    $mail->SMTPAuth   = true; // Enable SMTP authentication
		    $mail->Username   = $email; // SMTP username
			$mail->Password   = $password; // SMTP password

			// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
		    $mail->Port       = 587; // TCP port to connect to

		    
		    $mail->setFrom($email, 'Confirm Account'); // Recipients
		    $mail->addAddress($to, 'Joe User'); // Add a recipient

		    // Attachments
		    //$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
		    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

		    // Content
		    $mail->isHTML(true); // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    return $mail->send();
		} catch (Exception $e) {
		    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
?>