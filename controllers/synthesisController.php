<?php
	$dateBegin = date("Y-m-d", mktime(0, 0, 0, date("m")  , 1, date("Y")));
	$nbDays    = intval(date("t"));
	$dateEnd   = date("Y-m-d", mktime(0, 0, 0, date("m")  , $nbDays, date("Y")));
	$month     = date("m");

	$users = UserAccount::getUsersAccount($_SESSION['id_user']);

	$getMovements = Movement::getMovements($_SESSION['id_user'], $dateBegin, $dateEnd, $month);

	$movements  = $getMovements['movements'];
	$idsAccount = $getMovements['idsAccount'];
	$usersBilan = array();
	$cat        = array();

	foreach ($movements as $key => $movement)
	{
		$totalCat = 0;
		foreach ($movement as $m)
		{
			foreach ($users as $user)
			{
				if (!is_null($m['id_user_account']) && $user['id_user_account'] == $m['id_user_account'])
				{
					$bilan['amount']            = $m['calc_amount'];
					$bilan['debit']             = $m['debit'];
					$bilan['color']             = $m['color'];
					$bilan['name_user_account'] = $m['name_user_account'];

					if ($m['debit'] == "1")
					{
						if (!isset($cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['name_category_movement']]))
						{
							$cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['name_category_movement']]['amount'] = (float)$m['calc_amount'];
							$cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['name_category_movement']]['color']  = $m['color_movement'];
						}
						else
							$cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['name_category_movement']]['amount'] += (float)$m['calc_amount'];

						if (!isset($cat[$key.'*'.$m['id_account']][$user['id_user_account']]['total_category_movement']))
							$cat[$key.'*'.$m['id_account']][$user['id_user_account']]['total_category_movement']['amount'] = (float)$m['calc_amount'];
						else
							$cat[$key.'*'.$m['id_account']][$user['id_user_account']]['total_category_movement']['amount'] += (float)$m['calc_amount'];
					}
						

					$bilans[$key.'*'.$m['id_account']][$user['id_user_account']][] = $bilan;
				}
			}
			if(is_null($m['id_user_account']))
			{
				$bilan['amount']            = $m['calc_amount'];
				$bilan['debit']             = $m['debit'];
				$bilan['color']             = $m['color'];
				$bilan['name_user_account'] = $m['name_user_account'];

				if ($m['debit'] == "1")
				{
					if (!isset($cat[$key.'*'.$m['id_account']][0][$m['name_category_movement']]))
					{
						$cat[$key.'*'.$m['id_account']][0][$m['name_category_movement']]['amount'] = (float)$m['calc_amount'];
						$cat[$key.'*'.$m['id_account']][0][$m['name_category_movement']]['color']   = $m['color_movement'];
					}
					else
						$cat[$key.'*'.$m['id_account']][0][$m['name_category_movement']]['amount'] += (float)$m['calc_amount'];

					if (!isset($cat[$key.'*'.$m['id_account']][0]['total_category_movement']))
						$cat[$key.'*'.$m['id_account']][0]['total_category_movement']['amount'] = (float)$m['calc_amount'];
					else
						$cat[$key.'*'.$m['id_account']][0]['total_category_movement']['amount'] += (float)$m['calc_amount'];
				}

				$bilans[$key.'*'.$m['id_account']][0][] = $bilan;
			}
		}

		$usersBilan = $bilans;
	}

	$bilanUsers = array();

	foreach ($usersBilan as $key => $userBilan)
	{
		$bilUs = array();
		foreach ($userBilan as $k => $us)
		{
			$totalMonth  = 0;
			$totalDebit  = 0;
			$totalCredit = 0;
			foreach ($us as $u)
			{
				$totalCredit = ($u['debit'] == "0") ? (float)$totalCredit + (float)$u['amount'] : (float)$totalCredit;
				$totalDebit = ($u['debit'] == "1") ? (float)$totalDebit - (float)$u['amount'] : (float)$totalDebit;
				$totalMonth = ($u['debit'] == "1") ? (float)$totalMonth - (float)$u['amount'] : (float)$totalMonth + (float)$u['amount'];

				$bil['total_debit']       = $totalDebit;
				$bil['total_credit']      = $totalCredit;
				$bil['graph_debit']       = ((float)$totalDebit < 0) ? (float)$totalDebit * -1 : (float)$totalDebit;
				$bil['graph_credit']      = ((float)$totalCredit < 0) ? (float)$totalCredit * -1 : (float)$totalCredit;
				$bil['total_amount']      = $totalMonth;
				$bil['color']             = $u['color'];
				$bil['name_user_account'] = $u['name_user_account'];

				$bilUs[$k] = $bil;
			}
		}

		$bilanUsers[$key] = $bilUs;
	}

	/*$total = array();

	foreach ($bilanUsers as $key => $bilanUser)
	{
		$totalDebit  = 0;
		$totalCredit = 0;
		foreach ($bilanUser as $bil)
		{
			//if (!is_null($bil['name_user_account']))
				$totalCredit = (float)$totalCredit + (float)$bil['total_credit'];

			$totalDebit = (float)$totalDebit + (float)$bil['total_debit'];
		}

		$total[$key]['total_debit']  = $totalDebit;
		$total[$key]['total_credit'] = $totalCredit;
		$total[$key]['graph_debit']  = ((float)$totalDebit < 0) ? (float)$totalDebit * -1 : (float)$totalDebit;
		$total[$key]['graph_credit'] = ((float)$totalCredit < 0) ? (float)$totalCredit * -1 : (float)$totalCredit;
	}
var_dump($total);
	$bilanUsersTotal = array();*/

	/*foreach ($bilanUsers as $key => $bilanUser)
	{
		$bilanUserTotal = array();
		foreach ($bilanUser as $k => $bil)
		{
			$bilanUserTotal[$k] = $bil;

			$bilanUserTotal[$k]['percent_credit'] = $bil['total_credit'];


			$bilanUserTotal[$k]['percent_debit'] = $bil['total_debit'];
		}

		$bilanUsersTotal[$key] = $bilanUserTotal;
	}*/

	foreach ($idsAccount as $id)
	{
		$accountBal = AccountBalance::getAccountBalance($id);

		$accountsBalance[$id] = $accountBal;
	}

	$categoriesPercent = array();
	foreach ($cat as $key => $ca)
	{
		foreach ($ca as $k => $c)
		{
			$categorie = array();
			foreach ($c as $j => $cate)
			{
				if ($j != 'total_category_movement')
				{
					//$categorie[$j]['percent'] = round((float)$cate['amount'] * 100 / $c['total_category_movement']['amount'] , 2);
					$categorie[$j]['percent'] = $cate['amount'];
					$categorie[$j]['color']   = $cate['color'];
				}
			}
			
			$categories[$k] = $categorie;
		}

		$categoriesPercent[$key] = $categories;
	}