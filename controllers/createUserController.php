<?php

	if (!$_SESSION['nb_user'])
	{
		header("/../location:auth.php");
		exit;
	}
	else
	{
		$nb_user        = (int)$_SESSION['nb_user'];
		$titleNbUser    = ($nb_user == 1) ? "de l'utilisateur" : "des utilisateurs";
		$titleNbAccount = ($_SESSION['account'] == 1) ? "du compte" : "des comptes";
	}
	
