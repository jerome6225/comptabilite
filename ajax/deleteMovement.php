<?php
	include dirname(__FILE__)."/../include.php";

	$delete = Movement::deleteMovement($_POST['id_movement']);

	if ($delete)
	{
		$accountBalance = AccountBalance::getAccountBalance($_POST['idAccount']);
		if ($_POST['debit'] == "0")
		{
			$currentBalance = (float)$accountBalance->current_balance - (float)$_POST['amount'];
			$totalBalance   = (float)$accountBalance->balance_total - (float)$_POST['amount'];
		}
		else
		{
			$currentBalance = (float)$accountBalance->current_balance + (float)$_POST['amount'];
			$totalBalance   = (float)$accountBalance->balance_total + (float)$_POST['amount'];
		}

		AccountBalance::updateAccountBalance($_POST['idAccount'], $currentBalance, $totalBalance);

		echo 'ok';
		exit;
	}

	echo 'error';
	exit;