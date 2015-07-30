<?php
	include dirname(__FILE__)."/../include.php";

	$data = json_decode((string)$_POST["data"], true);
	
	$nbAccount = (int)$data['nb_account'];

	for ($i=0;$i<$nbAccount;$i++)
	{
		$idAccount = Account::addNewAccount($_SESSION['id_user'], htmlentities($data['account_name_'.$i]), $data['account_type_'.$i], $data['nb_user_'.$i]);

		if ($idAccount)
		{
			$idAccountBalance = AccountBalance::addNewAccountBalance($idAccount, 0, 0);
			$nbUser           = (int)$data['nb_user_'.$i];

			for ($j=0;$j<$nbUser;$j++)
			{
				if (!IdUserAccountIdAccount::addIdUserAccountIdAccount($data['id_user_account_'.$i.'_'.$j], $idAccount))
				{
					echo 'error';
					exit;
				}
			}
		}
		else
		{
			echo 'error';
			exit;
		}
	}
	
	echo 'ok';
	exit;