<?php
	include dirname(__FILE__)."/../include.php";

	$newLogin = User::isNewLogin($_POST['login']);

	if ($newLogin)
	{
		echo "ok";
		exit;
	}

	echo "error";
	exit;