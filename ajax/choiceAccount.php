<?php
	include dirname(__FILE__)."/../include.php";

	$account = Account::getAccount($_POST['select_choice_account']);

	if ($account)
	{
		$_SESSION['id_account']   = $_POST['select_choice_account'];
		$_SESSION['account_name'] = $account->name;

		echo $account->name;
		exit;
	}

	echo 'error';
	exit;