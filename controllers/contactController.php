<?php

$result       = false;
$mailPost     = false;
$checkCaptcha = false;

if (!empty($_POST))
{
	$mailPost = true;

	$captcha = new Recaptcha();

	if ($captcha->getCode($_POST['g-recaptcha-response'] == false)
		$result = false;
	else
	{
		$checkCaptcha = true;

		$mail  = "message de : ".$_POST['email']."\r\n";
		$mail .= "message : ".$_POST['message'];
		if (mail(_CONTACT_EMAIL_, 'contact ma compta', $mail))
			$result = true;
	}
	
	
}