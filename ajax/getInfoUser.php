<?php
	include dirname(__FILE__)."/../include.php";

	$users = UserAccount::getUsersAccount($_SESSION['id_user']);

	$html = '';
	foreach ($users as $user)
		$html .= '<option value="'.$user['id_user_account'].'">'.$user['name_user_account'].'</option>';

	echo $html;
	exit;