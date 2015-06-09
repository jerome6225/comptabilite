<?php
	include dirname(__FILE__)."/../include.php";

	$updateCheckDateDebit = Check::updateCheckDateDebit($_POST['id_check'],$_POST['date'], $_POST['id_movement']);

	if ($updateCheckDateDebit)
	{
		echo 'ok';
		exit;
	}

	echo 'error_add_check';
	exit;