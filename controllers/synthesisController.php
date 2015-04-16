<?php
	if (isset($_SESSION['id_user']))
	{
		if (!isset($_POST['month']))
		{
			$nbDays    = intval(date("t"));
			$dateBegin = date("Y-m-d", mktime(0, 0, 0, date("m")  , 1, date("Y")));
			$dateEnd   = date("Y-m-d", mktime(0, 0, 0, date("m")  , $nbDays, date("Y")));
			$month     = date("m");
		}
		else
		{
			$nbDays    = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['year']);
			$month     = (strlen($_POST['month']) == 1) ? '0'.$_POST['month'] : $_POST['month'];
			$dateBegin = $_POST['year'].'-'.$month.'-1';
			$dateEnd   = $_POST['year'].'-'.$month.'-'.$nbDays;
		}

		$getMovements = Movement::getMovements($_SESSION['id_user'], $dateBegin, $dateEnd, $month);

		$movements  = $getMovements['movements'];

		$categoryMovement = CategoryMovement::getCategoriesMovement();

		$users = UserAccount::getUsersAccount($_SESSION['id_user']);

		$months = Tools::getMonths();
		$years  = array_unique(Movement::getYearsMovement($_SESSION['id_user']));
	}