<?php
	include dirname(__FILE__)."/../include.php";

	$deleteMovement               = Movement::deleteUserAccountMovement($_POST['id_user_account']);
	$deleteIdUserAccountIdAccount = IdUserAccountIdAccount::deleteWithIdUserAccount($_POST['id_user_account']);
	$deleteUserAccount            = UserAccount::deleteUserAccount($_POST['id_user_account']);
	
	if ($deleteUserAccount)
	{
		echo 'ok';
		exit;
	}

	echo 'error';
	exit;