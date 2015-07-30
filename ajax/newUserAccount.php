<?php
	include dirname(__FILE__)."/../include.php";

	if (isset($_POST['nb_user']))
	{
		for ($i=0;$i<(int)$_POST['nb_user'];$i++)
		{
			$newUserAccount = UserAccount::addNewUserAccount($_SESSION['id_user'], htmlentities($_POST['user_name_'.$i]), $_POST['user_color_'.$i]);

			if (!$newUserAccount)
			{
				echo 'error_insert_user_account';
				exit;
			}
		}

		echo 'ok';
		exit;
	}
	else
	{
		$newUserAccount = UserAccount::addNewUserAccount($_SESSION['id_user'], htmlentities($_POST['user_name']), $_POST['user_color']);

		if (!$newUserAccount)
		{
			echo 'error_insert_user_account';
			exit;
		}

		echo 'ok';
		exit;
	}