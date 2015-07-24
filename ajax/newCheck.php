<?php
	include dirname(__FILE__)."/../include.php";

	$addCheck = Check::addCheck($_SESSION['id_user'], $_POST['id_account'], $_POST['id_user'], $_POST['number'], $_POST['amount'], $_POST['intitule'], $_POST['category'], $_POST['date']);
echo $addCheck;
	if ($addCheck)
	{
		//echo 'ok';
		exit;
	}
	else
	{
		//echo 'error_check';
		exit;
	}
