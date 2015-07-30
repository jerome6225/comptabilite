<?php
	include dirname(__FILE__)."/../include.php";

	if (!User::isNewLogin($_POST['login']))
	{
		echo "error_login";
		exit;
	}

	$idUser = User::addNewUser(htmlentities($_POST['first_name']), htmlentities($_POST['last_name']), htmlentities($_POST['login']), md5($_POST['password']), $_POST['account'], $_POST['nb_user']);

	if ($idUser)
	{
		$_SESSION['id_user']    = $idUser;
		$_SESSION['first_name'] = htmlentities($_POST['first_name']);
		$_SESSION['last_name']  = htmlentities($_POST['last_name']);
		$_SESSION['login']      = htmlentities($_POST['login']);
		$_SESSION['account']    = $_POST['account'];
		$_SESSION['nb_user']    = $_POST['nb_user'];

		echo 'ok';
		exit;
	}
	else
	{
		echo "error";
		exit;
	}

	