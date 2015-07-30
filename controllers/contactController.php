<?php

$result   = false;
$mailPost = false;

if (isset($_POST['email']))
{
	$mailPost = true;
	$mail  = "message de : ".$_POST['email']."\r\n";
	$mail .= "message : ".$_POST['message'];
	if (mail(_CONTACT_EMAIL_, 'contact ma compta', $mail))
		$result = true;
}