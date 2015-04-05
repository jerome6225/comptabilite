<?php

	$user = User::getInfoUserWithNameAndlogin($_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['login']);
	if ($user)
	{
		$accountType = TypeAccount::getTypesAccount();
	}