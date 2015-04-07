<?php
	include dirname(__FILE__)."/../include.php";

	$update = Movement::updateMovement($_POST['id_movement'], $_POST['user'], $_POST['amount'], $_POST['date_begin'], $_POST['name'], $_POST['category'], $_POST['date_end']);

	if ($update)
	{
		$categoryMovement = CategoryMovement::getNameCategoryMovement($_POST['category']);

		if ($_POST['amount'] != $_POST['oldAmount'])
		{
			$accountBalance = AccountBalance::getAccountBalance($_POST['idAccount']);

			if ($_POST['debit'] == "0")
			{
				$currentBalance = (float)$accountBalance->current_balance - (float)$_POST['oldAmount'] + (float)$_POST['amount'];
				$totalBalance   = (float)$accountBalance->balance_total - (float)$_POST['oldAmount'] + (float)$_POST['amount'];
			}
			else
			{
				$currentBalance = (float)$accountBalance->current_balance + (float)$_POST['oldAmount'] - (float)$_POST['amount'];
				$totalBalance   = (float)$accountBalance->balance_total + (float)$_POST['oldAmount'] - (float)$_POST['amount'];
			}

			AccountBalance::updateAccountBalance($_POST['idAccount'], $currentBalance, $totalBalance);
		}

		echo $categoryMovement->name_category_movement;
		exit;
	}
	else
	{
		echo 'error';
		exit;
	}