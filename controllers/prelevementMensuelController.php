<?php

	$depenseCommune = (isset($_POST['somme'])) ? $_POST['somme'] : 0;

	$users     = UserAccount::getUsersAccount($_SESSION['id_user']);
	$movements = Movement::getPeriodicMovement($_SESSION['id_user']);

	$cat = array();

	foreach ($movements as $key => $movement)
	{
		$totalCat = 0;
		foreach ($movement as $m)
		{
			foreach ($users as $user)
			{
				if (!is_null($m['id_user_account']) && $user['id_user_account'] == $m['id_user_account'])
				{
					if (!isset($cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['debit']]['total_category_movement']))
					{
						$cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['debit']]['total_category_movement']['amount']  = (float)$m['calc_amount'];
						$cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['debit']]['total_category_movement']['name'] = $m['name_user_account'];
					}
					else
						$cat[$key.'*'.$m['id_account']][$user['id_user_account']][$m['debit']]['total_category_movement']['amount'] += (float)$m['calc_amount'];
				}
			}
			if(is_null($m['id_user_account']))
			{
				if (!isset($cat[$key.'*'.$m['id_account']][0][$m['debit']]['total_category_movement']))
				{
					$cat[$key.'*'.$m['id_account']][0][$m['debit']]['total_category_movement']['amount'] = (float)$m['calc_amount'];
					$cat[$key.'*'.$m['id_account']][0][$m['debit']]['total_category_movement']['name'] = $m['name_user_account'];
				}
				else
					$cat[$key.'*'.$m['id_account']][0][$m['debit']]['total_category_movement']['amount'] += (float)$m['calc_amount'];
			}
		}
	}

	$totalCredit = array();
	foreach ($cat as $key => $ca)
	{
		$totalCred = 0;
		foreach ($ca as $k => $c)
		{
			foreach ($c as $j => $cate)
			{
				if ($k != 0 && $j == 0)
					$totalCred += $cate['total_category_movement']['amount'];
			}
		}

		$totalCredit[$key] = $totalCred;
	}

	$categories = array();
	foreach ($cat as $key => $ca)
	{
		$categ = array();
		foreach ($ca as $k => $c)
		{
			$ca = array();
			foreach ($c as $j => $cate)
			{
				$category = array();

				$category['total_category_movement']['amount'] = $cate['total_category_movement']['amount'];
				$category['total_category_movement']['name'] = $cate['total_category_movement']['name'];
				if ($depenseCommune != 0)
					$category['total_category_movement']['totalCommun'] = $depenseCommune;
				if ($k != 0 && $j == 0)
				{
					$category['total_category_movement']['percent']   = round((float)$cate['total_category_movement']['amount'] * 100 / $totalCredit[$key] , 2);

					$totalDebitMonth = (float)$cat[$key][0][1]['total_category_movement']['amount'] - (float)$cat[$key][0][0]['total_category_movement']['amount'];

					$category['total_category_movement']['totalPaid'] = round((float)$totalDebitMonth * (float)$cate['total_category_movement']['amount'] * 100 / $totalCredit[$key] / 100, 2);
					$category['total_category_movement']['rest'] = (float)$cate['total_category_movement']['amount'] - (float)$category['total_category_movement']['totalPaid'];
					if (isset($c[1]['total_category_movement']['amount']))
						$category['total_category_movement']['rest'] -= (float)$c[1]['total_category_movement']['amount'];

					if ($depenseCommune != 0)
					{
						$category['total_category_movement']['sommeCommun'] = round($depenseCommune * (float)$cate['total_category_movement']['amount'] * 100 / $totalCredit[$key] / 100, 2);
						$category['total_category_movement']['rest']       -= (float)$category['total_category_movement']['sommeCommun'];
					}
						
				}

				$ca[$j] = $category;
			}
			$categ[$k] = $ca;
		}

		$categories[$key] = $categ;
	}