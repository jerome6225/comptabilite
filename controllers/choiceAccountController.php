<?php

	if (isset($_SESSION['id_user']))
		$accounts = Account::getAccounts($_SESSION['id_user']);
	