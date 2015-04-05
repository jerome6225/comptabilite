<?php
	include dirname(__FILE__)."/../include.php";

	$delete = Movement::deleteMovement($_POST['id_movement']);

	if ($delete)
	{
		echo 'ok';
		exit;
	}

	echo 'error';
	exit;