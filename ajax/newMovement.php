<?php
	include dirname(__FILE__)."/../include.php";

	$addMovement = Movement::addMovement($_SESSION['id_user'], $_POST['id_account'], $_POST['id_user'], $_POST['amount'], $_POST['debit'], $_POST['date'], $_POST['monthly'], $_POST['annual'], $_POST['intitule'], $_POST['category'], $_POST['date_end'], $_POST['nb_month']);
	
	if ($addMovement)
	{
		$accountBalance = accountBalance::getAccountBalance($_POST['id_account']);

		if ($_POST['date'] <= date("Y-m-d"))
		{
			$newCurrentBalance = ($_POST['debit'] == "1") ? (float)$accountBalance->current_balance - (float)$_POST['amount'] : (float)$accountBalance->current_balance + (float)$_POST['amount'];
		}
		else
		{
			$newCurrentBalance = (float)$accountBalance->current_balance;
		}
		
		$newTotalBalance   = ($_POST['debit'] == "1") ? (float)$accountBalance->balance_total - (float)$_POST['amount'] : (float)$accountBalance->balance_total + (float)$_POST['amount'];

		$update = AccountBalance::updateAccountBalance($_POST['id_account'], $newCurrentBalance, $newTotalBalance);
		
		if ($_POST['category'] == '17' && $_POST['account_assoc'] != "0")
		{
			$debitOtherAccount = ($_POST['debit'] == "1") ? "0" : "1";

			$addMovementOtherAccount = Movement::addMovement($_SESSION['id_user'], $_POST['account_assoc'], $_POST['id_user'], $_POST['amount'], $debitOtherAccount, $_POST['date'], $_POST['monthly'], $_POST['annual'], $_POST['intitule'], $_POST['category'], $_POST['date_end'], $_POST['nb_month']);
			
			$accountBalanceOtherAccount = accountBalance::getAccountBalance($_POST['account_assoc']);

			if ($_POST['date'] <= date("Y-m-d"))
			{
				$newCurrentBalanceOtherAccount = ($debitOtherAccount == "1") ? (float)$accountBalanceOtherAccount->current_balance - (float)$_POST['amount'] : (float)$accountBalanceOtherAccount->current_balance + (float)$_POST['amount'];
			}
			else
			{
				$newCurrentBalanceOtherAccount = (float)$accountBalanceOtherAccount->current_balance;
			}
			
			$newTotalBalanceOtherAccount   = ($debitOtherAccount == "1") ? (float)$accountBalanceOtherAccount->balance_total - (float)$_POST['amount'] : (float)$accountBalanceOtherAccount->balance_total + (float)$_POST['amount'];

			$update = AccountBalance::updateAccountBalance($_POST['account_assoc'], $newCurrentBalanceOtherAccount, $newTotalBalanceOtherAccount);
		}
		
		echo $addMovement;
		exit;
	}
	else
	{
		echo 'error_movement';
		exit;
	}	