<?php
	include dirname(__FILE__)."/../include.php";

	$usersAccount = UserAccount::getUsersAccount($_SESSION['id_user']);

	$html = '';

	for ($i=0;$i<$_POST['nb_user'];$i++)
	{
		$nbUser = ($i == 0) ? '1er' : ($i +1).'&egrave;me';

		$html .= '<div class="form-group has-feedback" id="div_new_customer_account_nb_user_'.$_POST['current'].'_'.$i.'">';
		$html .= '<label for="customer_user_account_name_'.$_POST['current'].'_'.$i.'">Nom du '.$nbUser.' utilisateur : </label>';
		$html .= '<select class="form-control" id="customer_user_account_name_'.$_POST['current'].'_'.$i.'">';

		foreach ($usersAccount as $userAccount)
		{
			$html .= '<option value="'.$userAccount['id_user_account'].'">'.$userAccount['name_user_account'].'</option>';
		}

		$html .= '</select>';
		$html .= '</div>';
	}

	echo $html;
	exit;
