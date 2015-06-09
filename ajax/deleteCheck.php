<?php
	include dirname(__FILE__)."/../include.php";

	$deleteCheck = Check::deleteCheck($_POST['id_check']);

	if ($deleteCheck)
	{
		if (!is_null($_POST['id_movement']))
		{
			$delete = Movement::deleteMovement($_POST['id_movement']);

			if ($delete)
			{
				$accountBalance = AccountBalance::getAccountBalance($_POST['idAccount']);
				$currentBalance = (float)$accountBalance->current_balance + (float)$_POST['amount'];
				$totalBalance   = (float)$accountBalance->balance_total + (float)$_POST['amount'];

				AccountBalance::updateAccountBalance($_POST['idAccount'], $currentBalance, $totalBalance);

				echo 'ok';
				exit;
			}

			echo 'error';
			exit;
		}
		else
		{
			echo 'ok';
			exit;
		}
	}

	echo 'error';
	exit;
