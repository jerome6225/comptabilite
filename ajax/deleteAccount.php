<?php
	include dirname(__FILE__)."/../include.php";

	$deleteMovement               = Movement::deleteAccountMovement($_POST['account']);
	$deleteIdUserAccountIdAccount = IdUserAccountIdAccount::deleteWithIdAccount($_POST['account']);
	$deleteAccountBalance         = AccountBalance::deleteAccountBalance($_POST['account']);
	$deleteAccount                = Account::deleteAccount($_POST['account']);

	if ($deleteMovement && $deleteIdUserAccountIdAccount && $deleteAccountBalance && $deleteAccount)
	{
		echo 'ok';
		exit;
	}

	echo 'error';
	exit;