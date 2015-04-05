<?php
	include dirname(__FILE__)."/../include.php";

	$result = User::getPassword($_SESSION['id_user'], $_POST['old_password']);

	if ($result && isset($result->password))
	{
		$update = User::updateUserPassword($_SESSION['id_user'], $_POST['new_password']);

		if ($update)
		{
			echo "ok";
			exit;
		}
		else
		{
			echo "error_update";
			exit;
		}
		
	}
	else
	{
		echo "error_password";
		exit;
	}