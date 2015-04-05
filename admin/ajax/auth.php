<?php
	include dirname(__FILE__)."/../../include.php";

	$sql = $pdo->query("SELECT * FROM admin WHERE mail = '".$_POST['login']."' AND password = '".md5($_POST['password'])."'");
	$result = $sql->fetch(PDO::FETCH_OBJ);

	if ($result)
	{
		$_SESSION['id_admin']   = $result->id_admin;
		$_SESSION['first_name'] = $result->first_name;
		$_SESSION['last_name']  = $result->last_name;
		$_SESSION['mail']       = $result->mail;
		$_SESSION['type_admin'] = $result->type_admin;

		echo 'ok';
		exit;
	}

	echo 'error';
	exit;