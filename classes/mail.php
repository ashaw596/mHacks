<?php
	require_once(__DIR__."/mail/email.php");
	
	function contactUS($name, $email, $phone, $message) {
		$subject = "ContactUS Burnizer Email";
		$message = "Name: $name <br />
					Email: $email<br />
					Phone: $phone<br />
					Feedback: $message";
		$email = "burnizers@gmail.com";
		sendEmail($email, $message, $subject);
	}
?>