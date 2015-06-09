<?php
	include dirname(__FILE__)."/../include.php";

ob_start();
var_dump($_POST['id_account']);
$result = ob_get_clean();
file_put_contents(dirname(__FILE__).'/log.txt',$result,FILE_APPEND);
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
		
		echo $addMovement;
		exit;
	}
	else
	{
		echo 'error_movement';
		exit;
	}	