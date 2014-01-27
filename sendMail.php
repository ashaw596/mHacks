<?php
	require_once(__DIR__."/classes/mail.php");
	if(isset($_POST["name"])) {
		$name = $_POST["name"];
	}
	if(isset($_POST["email"])) {
		$email = $_POST["email"];
	}
	if(isset($_POST["phonenumber"])) {
		$phonenumber = $_POST["phonenumber"];
	}
	if(isset($_POST["phonenumber2"])) {
		$phonenumber2 = $_POST["phonenumber2"];
	}
	if(isset($_POST["phonenumber3"])) {
		$phonenumber3 = $_POST["phonenumber3"];
	}
	if(isset($_POST["message"])) {
		$message = $_POST["message"];
	}
	$phone = $phonenumber . $phonenumber2 . $phonenumber3;
	contactUS($name, $email, $phone, $message);
?>
	<script> alert("Feedback Sent"); window.history.back(); </script>