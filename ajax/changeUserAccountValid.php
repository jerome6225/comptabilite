<?php
	include dirname(__FILE__)."/../include.php";

	$update = UserAccount::updateUserAccount($_POST['id_user_account'], $_POST['name_user_account'], $_POST['color']);
	
	if ($update)
	{
		echo 'ok';
		exit;
	}

	echo 'error';
	exit;