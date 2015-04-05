<?php
	if (isset($_SESSION['id_user']))
	{
		if (!isset($_POST['date_begin']))
		{
			$dateBegin = date("Y-m-d", mktime(0, 0, 0, date("m")  , 1, date("Y")));
			$nbDays = intval(date("t"));
			$dateEnd = date("Y-m-d", mktime(0, 0, 0, date("m")  , $nbDays, date("Y")));
			$month = date("m");
		}
		else
		{
			$dateExpl = explode("/", $_POST['date_begin']);
			$dateBegin = $dateExpl[2].'-'.$dateExpl[0].'-'.$dateExpl[1];

			$dateExpl = explode("/", $_POST['date_end']);
			$dateEnd = $dateExpl[2].'-'.$dateExpl[0].'-'.$dateExpl[1];
			$month = $dateExpl[0];
		}

		$getMovements = Movement::getMovements($_SESSION['id_user'], $dateBegin, $dateEnd, $month);

		$movements  = $getMovements['movements'];

		$categoryMovement = CategoryMovement::getCategoriesMovement();
	}