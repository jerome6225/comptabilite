<?php
	include dirname(__FILE__)."/../include.php";

	$delete = Movement::deleteMovement($_POST['id_movement']);

	if ($delete)
	{
		if ($_POST['id_movement_assoc'] != 0)
		{
			$accountAssoc = Movement::getMovement($_POST['id_movement_assoc']);

			$deleteMovementAssoc = Movement::deleteMovement($_POST['id_movement_assoc']);

			if ($deleteMovementAssoc)
			{
				$accountBalanceAssoc = AccountBalance::getAccountBalance($accountAssoc->id_account);
				if ($_POST['debit'] == "0")
				{
					$currentBalanceAssoc = (float)$accountBalanceAssoc->current_balance + (float)$_POST['amount'];
					$totalBalanceAssoc   = (float)$accountBalanceAssoc->balance_total + (float)$_POST['amount'];
				}
				else
				{
					$currentBalanceAssoc = (float)$accountBalanceAssoc->current_balance - (float)$_POST['amount'];
					$totalBalanceAssoc   = (float)$accountBalanceAssoc->balance_total - (float)$_POST['amount'];
				}

				AccountBalance::updateAccountBalance($accountAssoc->id_account, $currentBalanceAssoc, $totalBalanceAssoc);
			}
		}
		
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

		if ($_POST['id_movement_assoc'] != 0)
			echo $accountAssoc->id_account;
		else
			echo 'ok';
		exit;
	}

	echo 'error';
	exit;