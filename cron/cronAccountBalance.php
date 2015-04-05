<?php
	include dirname(__FILE__)."/../include.php";

	$day    = date('d');
	$nbDays = date('t');

	if ($nbDays == '28' && $day == '28')
		$daysLike = array(
			'0' => "%".date("d"),
			'1' => "%29",
			'2' => "%30",
			'3' => "%31"
			);
	else if ($nbDays == '29' && $day == '29')
		$daysLike = array(
			'0' => "%".date("d"),
			'1' => "%30",
			'2' => "%31"
			);
	else if ($nbDays == '30' && $day == '30')
		$daysLike = array(
			'0' => "%".date("d"),
			'1' => "%31"
			);
	else
		$daysLike = array(
			'0' => "%".date("d")
			);

	echo 'begin cron <br />';

	foreach ($daysLike as $dayLike)
	{
		$sql = $pdo->query("SELECT m.id_account, m.amount, m.debit
			FROM movement as m 
			WHERE m.date_movement LIKE '".$dayLike."' 
				AND m.monthly = 1 
				AND (m.date_end > '".date("Y-m-d")."' OR m.date_end = '0000-00-00')
				AND (m.annual = 1 OR (nb_month <= '".date("m")."'))");

		$sql->setFetchMode(PDO::FETCH_ASSOC);
		
		while($res = $sql->fetch())
		{
			$s = $pdo->query("SELECT * FROM account_balance WHERE id_account = ".(int)$res['id_account']);
			$accountBal = $s->fetch(PDO::FETCH_OBJ);
			echo 'new movement: '.$res['amount'].' old balance: '.$accountBal->current_balance.'<br />';

			$newBalance = ($res['debit'] == "1") ? (float)$accountBal->current_balance - (float)$res['amount'] : (float)$accountBal->current_balance + (float)$res['amount'];
			echo 'new balance: '.$newBalance.'<br />';
			$update = $pdo->exec("UPDATE account_balance SET current_balance = '".$newBalance."' WHERE id_account = ".(int)$res['id_account']);
			echo 'update: '.$res['id_account_balance'];
		}
	}

	echo 'end.';
	exit;

