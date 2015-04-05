<?php
	include dirname(__FILE__)."/../include.php";

	for ($i=0;$i<$_POST['nb_user'];$i++)
	{
		if (IdUserAccountIdAccount::addIdUserAccountIdAccount($_POST['user_id_'.$i], $_POST['id_account']) === false)
		{
			echo 'error';
			exit;
		}
	}
	echo 'ok';
	exit;