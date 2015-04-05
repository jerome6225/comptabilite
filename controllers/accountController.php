<?php

	$result = User::getInfoUserWithNameAndlogin($_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['login']);

	if ($result)
	{
		$accountType = TypeAccount::getTypesAccount();

		$_SESSION['id_user'] = $result->id_user;
		$account             = (int) $_SESSION['account'];
	}