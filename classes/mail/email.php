<html>
<body>
<?php
include_once(__DIR__ . "/class.phpmailer.php");
include_once(__DIR__ . "/class.smtp.php");

function sendEmail($email, $message, $subject, $text="") {

	$mail             = new PHPMailer();

	$body             = $message;

	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port

	$mail->Username   = "burnizers@gmail.com";  // GMAIL username
	$mail->Password   = "schoolschool";            // GMAIL password

	$mail->From       = "burnizers@gmail.com";
	$mail->FromName   = "Burnizer Bot";
	$mail->Subject    = $subject;
	$mail->WordWrap   = 50; // set word wrap

	$mail->MsgHTML($body);

	$mail->AddAddress("$email");

	$mail->IsHTML(true); // send as HTML
	$mail->AddReplyTo("burnizers@gmail.com","Burnizer Robot");

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
		return false;
	} else {
		return true;
	}
}

?>
</body>
</html>