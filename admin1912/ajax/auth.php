<?php
	include dirname(__FILE__)."/../../include.php";

	$mail = Admin::getInfoMail($_POST['mail'], $_POST['password']);

	if ($mail)
	{
		$_SESSION['id_admin']   = $mail->id_admin;
		$_SESSION['first_name'] = $mail->first_name;
		$_SESSION['last_name']  = $mail->last_name;
		$_SESSION['mail']       = $mail->mail;
		$_SESSION['type_admin'] = $mail->type_admin;

		echo 'ok';
		exit;
	}

	echo 'error';
	exit;