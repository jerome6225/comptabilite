<?php
	include dirname(__FILE__)."/../include.php";

	if ($_POST['status'] == 1)
		$statusRemboursement = Remboursement::updateStatusRemboursement($_POST['idRemboursement'], 0);
	else
		$statusRemboursement = Remboursement::updateStatusRemboursement($_POST['idRemboursement'], 1);

	if ($statusRemboursement)
	{
		echo 'ok';
		exit;
	}

	echo 'error';
	exit;
