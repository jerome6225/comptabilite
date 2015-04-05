<?php
	include dirname(__FILE__)."/../include.php";

	$idAccount = $_SESSION['id_account_modif'];
	$data = json_decode((string)$_POST["data"], true);

	$update = Account::updateAccount($idAccount, $data['account_name'], $data['account_type'], $data["nb_user"]);

	if ($update)
	{
		IdUserAccountIdAccount::deleteWithIdAccount($idAccount);

		for ($i=0;$i<(int)$data['nb_user'];$i++)
			if (!IdUserAccountIdAccount::addIdUserAccountIdAccount($data['id_user_account_'.$i], $idAccount))
			{
				echo 'error';
				exit;
			}

		echo 'ok';
		exit;
	}

	echo 'error';
	exit;