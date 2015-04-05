<?php
	include dirname(__FILE__)."/../include.php";

	$login = User::getInfoLogin($_POST['login'], $_POST['password']);

	if ($login)
	{
		$_SESSION['id_user']    = $login->id_user;
		$_SESSION['first_name'] = $login->first_name;
		$_SESSION['last_name']  = $login->last_name;
		$_SESSION['login']      = $login->login;
		$_SESSION['account']    = $login->account;
		echo 'ok';
		exit;
	}
	else
	{
		$check = User::isNewLogin($_POST['login']);

		if ($check)
		{
			echo 'error_login';
			exit;
		}
		else
		{
			echo 'error_password';
			exit;
		}
	}