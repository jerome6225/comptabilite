<?php
	include dirname(__FILE__)."/../include.php";

	$accounts = Account::getAccounts($_SESSION['id_user']);
	$emprunts = Emprunt::getEmprunts($_SESSION['id_user']);

	foreach ($accounts as $account)
	{
		if (!AccountBalance::deleteAccountBalance($account) || !IdUserAccountIdAccount::deleteWithIdUserAccount($account))
		{
			echo 'error';
			exit;
		}
	}

	foreach ($emprunts as $emprunt)
	{
		if (!Remboursement::deleteRemboursement($emprunt))
		{
			echo 'error';
			exit;
		}
	}

	if (!Emprunt::deleteEmprunts($_SESSION['id_user']) || 
		!Check::deleteChecks($_SESSION['id_user']) || 
		!Account::deleteAccounts($_SESSION['id_user']) || 
		!Movement::deleteUserMovement($_SESSION['id_user']) || 
		!UserAccount::deleteUserAccounts($_SESSION['id_user']) || 
		!User::deleteUser($_SESSION['id_user']))
	{
		echo 'error';
		exit;
	}
	
	session_start();
	$_SESSION = array(); 
	session_unset();
	session_destroy();
	
	echo 'ok';

	exit;
