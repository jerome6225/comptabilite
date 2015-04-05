<?php
	include dirname(__FILE__)."/../include.php";

	$accounts = Account::getAccounts($_SESSION['id_user']);

	$html = '';
	foreach ($accounts as $a)
		$html .= '<option value="'.$a['id_account'].'">'.$a['name'].'</option>';

	echo $html;
	exit;