<?php
	include dirname(__FILE__)."/../include.php";

	$update = Movement::updateMovement($_POST['id_movement'], $_POST['user'], $_POST['amount'], $_POST['date_begin'], $_POST['name'], $_POST['category'], $_POST['date_end']);
	$result = array();

	if ($update)
	{
		if ($_POST['id_movement_assoc'] != 0)
		{
			$accountAssoc = Movement::getMovement($_POST['id_movement_assoc']);
			$updateAssoc  = Movement::updateMovement($_POST['id_movement_assoc'], $_POST['user'], $_POST['amount'], $_POST['date_begin'], $_POST['name'], $accountAssoc->movement_category, $_POST['date_end']);

			if ($_POST['amount'] != $_POST['oldAmount'])
			{
				$accountBalanceAssoc = AccountBalance::getAccountBalance($accountAssoc->id_account);
				if ($_POST['debit'] == "0")
				{
					$currentBalanceAssoc = (float)$accountBalanceAssoc->current_balance + (float)$_POST['oldAmount'] - (float)$_POST['amount'];
					$totalBalanceAssoc   = (float)$accountBalanceAssoc->balance_total + (float)$_POST['oldAmount'] - (float)$_POST['amount'];
				}
				else
				{
					$currentBalanceAssoc = (float)$accountBalanceAssoc->current_balance - (float)$_POST['oldAmount'] +(float)$_POST['amount'];
					$totalBalanceAssoc   = (float)$accountBalanceAssoc->balance_total - (float)$_POST['oldAmount'] + (float)$_POST['amount'];
				}

				AccountBalance::updateAccountBalance($accountAssoc->id_account, $currentBalanceAssoc, $totalBalanceAssoc);
			}

			$result['idAccountAssoc'] = $accountAssoc->id_account;
		}

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

		$userInfo = UserAccount::getUserAccount($_POST['user']);
		$result['categoryMovement'] = $categoryMovement->name_category_movement;
		$result['userName']         = $userInfo->name_user_account;
		$result['userColor']        = $userInfo->color;
		echo json_encode($result);
		exit;
	}
	else
	{
		echo 'error';
		exit;
	}