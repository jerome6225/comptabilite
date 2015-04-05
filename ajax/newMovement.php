<?php
	include dirname(__FILE__)."/../include.php";

	$addMovement = Movement::addMovement($_SESSION['id_user'], $_SESSION['id_account'], $_POST['id_user'], $_POST['amount'], $_POST['debit'], $_POST['date'], $_POST['monthly'], $_POST['annual'], $_POST['intitule'], $_POST['category'], $_POST['date_end'], $_POST['nb_month']);
	
	if ($addMovement)
	{
		$accountBalance = accountBalance::getAccountBalance($_SESSION['id_account']);

		if ($_POST['date'] <= date("Y-m-d"))
		{
			$newCurrentBalance = ($_POST['debit'] == "1") ? (float)$accountBalance->current_balance - (float)$_POST['amount'] : (float)$accountBalance->current_balance + (float)$_POST['amount'];
		}
		else
		{
			$newCurrentBalance = (float)$accountBalance->current_balance;
		}
		
		$newTotalBalance   = ($_POST['debit'] == "1") ? (float)$accountBalance->balance_total - (float)$_POST['amount'] : (float)$accountBalance->balance_total + (float)$_POST['amount'];

		$update = AccountBalance::addNewAccountBalance($_SESSION['id_account'], $newCurrentBalance, $newTotalBalance);
		
		if (!isset($_SESSION['nb_movement']))
		{
			$_SESSION['nb_movement'] = 1;
			$movementTitle = $_SESSION['nb_movement'].' entr&eacute;e';
		}
		else
		{
			$_SESSION['nb_movement'] += 1;
			$movementTitle = $_SESSION['nb_movement'].' entr&eacute;es';
		}

		echo 'Vous avez &eacute;ffectu&eacute; '.$movementTitle;
		exit;
	}
	else
	{
		echo 'error_movement';
		exit;
	}	