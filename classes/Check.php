<?php

	class Check{

		public function __construct()
		{

		}

		public static function getChecksAccount($idAccount, $dateBegin, $dateEnd, $month)
		{
			$pdo = Db::getInstance();
			$sql = $pdo->query("SELECT c.*, cm.name_category_movement, cm.id_category_movement, ua.id_user_account, ua.color, ua.name_user_account, a.name as name_account
			FROM `check` as c 
			LEFT JOIN category_movement as cm ON(c.check_category = cm.id_category_movement)
			LEFT JOIN user_account as ua ON(c.id_user_account = ua.id_user_account)
			LEFT JOIN account as a ON(c.id_account = a.id_account)
			WHERE c.id_account = ".$idAccount." 
			AND ((c.date_release_check BETWEEN '".$dateBegin."' AND '".$dateEnd."') OR (c.date_release_check <= '".$dateEnd."' AND ISNULL(c.date_debit) = 1))
			ORDER BY c.date_release_check");

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$checks  = array();
			$idsAccount = array();

			while($res = $sql->fetch())
			{
				$check['amount']                    = number_format((float)$res['amount'], 2);
				$check['string_date_release_check'] = Tools::formatDate($res['date_release_check']);
				$check['date_debit']                = $res['date_debit'];
				$check['string_date_debit']         = Tools::formatDate($res['date_debit']);
				$check['date_release_check']        = $res['date_release_check'];
				$check['name_check']          	    = $res['name_check'];
				$check['movement_category']         = $res['id_category_movement'];
				$check['id_check']                  = $res['id_check'];
				$check['id_account']                = $res['id_account'];
				$check['name_user_account']         = $res['name_user_account'];
				$check['id_user_account']           = $res['id_user_account'];
				$check['name_category_movement']    = $res['name_category_movement'];
				$check['color']                     = $res['color'];
				$check['id_movement']               = $res['id_movement'];

				$checks[$res['name_account']][] = $check;
				$idsAccount[$res['id_account']] = $res['id_account'];
			}

			return array(
				'checks'  => $checks,
				'idsAccount' => $idsAccount
			);
		}

		public static function deleteCheck($idCheck)
		{
			$where = array(
				'id_check' => array(PDO::PARAM_INT => $idCheck),
			);

			return Db::delete('check', $where);
		}

		public static function updateCheckDateDebit($idCheck, $dateDebit, $idMovement)
		{
			$fields = array(
				'date_debit'  => array(PDO::PARAM_STR => $dateDebit),
				'id_movement' => array(PDO::PARAM_STR => $idMovement),
			);

			$where = array(
				'id_check' => array(PDO::PARAM_INT => $idCheck),
			);

			return Db::update('check', $fields, $where);
		}

		public static function addCheck($idUser, $idAccount, $idUserAccount, $amount, $nameCheck, $checkCategory, $dateReleaseCheck)
		{
			$fields = array(
				'id_user'            => array(PDO::PARAM_INT => $idUser),
				'id_account'         => array(PDO::PARAM_STR => $idAccount),
				'id_user_account'    => array(PDO::PARAM_INT => $idUserAccount),
				'amount'             => array(PDO::PARAM_STR => $amount),
				'name_check'         => array(PDO::PARAM_STR => $nameCheck),
				'check_category'     => array(PDO::PARAM_STR => $checkCategory),
				'date_release_check' => array(PDO::PARAM_STR => $dateReleaseCheck),
			);

			return Db::insert('check', $fields);
		}

		public static function getYearsCheck($idUser)
		{
			$pdo = Db::getInstance();

			$sql = $pdo->query("SELECT DISTINCT date_release_check
			FROM `check` 
			WHERE id_user = ".$idUser);

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$years = array();
			while($res = $sql->fetch())
			{
				$date = explode("-", $res['date_release_check']);
				$years[] = $date[0];
			}

			return $years;
		}
	}