<?php
	include dirname(__FILE__)."/../include.php";

	$sql = $pdo->query("SELECT m.id_account, m.amount, m.debit
			FROM movement as m 
			WHERE m.monthly = 1 
				AND (m.date_end > '".date("Y-m-d")."' OR m.date_end = '0000-00-00')
				AND (m.annual = 1 OR (nb_month <= '".date("m")."'))");

	$sql->setFetchMode(PDO::FETCH_ASSOC);
	echo 'begin cron <br />';
	while($res = $sql->fetch())
	{
		$s = $pdo->query("SELECT * FROM account_balance WHERE id_account = ".(int)$res['id_account']);
		$accountBal = $s->fetch(PDO::FETCH_OBJ);
		echo 'new movement: '.$res['amount'].' old balance: '.$accountBal->balance_total.'<br />';

		$newBalance = ($res['debit'] == "1") ? (float)$accountBal->balance_total - (float)$res['amount'] : (float)$accountBal->balance_total + (float)$res['amount'];
		echo 'new balance: '.$newBalance.'<br />';
		$update = $pdo->exec("UPDATE account_balance SET balance_total = '".$newBalance."' WHERE id_account = ".(int)$res['id_account']);
		echo 'update: '.$res['id_account_balance'];
	}

	echo 'end.';
	exit;