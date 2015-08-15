<?php

	class Movement{

		public function __construct()
		{

		}

		public static function getMovements($idUser, $dateBegin, $dateEnd, $month)
		{
			$pdo = Db::getInstance();
			$sql = $pdo->query("SELECT m.*, cm.name_category_movement, cm.color as color_movement, ua.id_user_account, ua.name_user_account, ua.color, a.name as name_account
			FROM movement as m 
			LEFT JOIN category_movement as cm ON(m.movement_category = cm.id_category_movement)
			LEFT JOIN user_account as ua ON(m.id_user_account = ua.id_user_account)
			LEFT JOIN account as a ON(m.id_account = a.id_account)
			WHERE m.id_user = ".$idUser." 
			AND ((m.date_movement BETWEEN '".$dateBegin."' AND '".$dateEnd."')
				OR (m.monthly = 1 
					AND ((m.date_movement < '".$dateEnd."' AND (m.date_end > '".$dateEnd."' OR m.date_end = '0000-00-00'))
					OR (m.annual = 1 OR nb_month >= '".$month."'))))
			ORDER BY m.date_movement ASC");

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$movements  = array();
			$idsAccount = array();

			while($res = $sql->fetch())
			{
				$movement['amount']                 = number_format((float)$res['amount'], 2);
				$movement['debit']                  = $res['debit'];
				$movement['color_debit']            = ($res['debit']) ? 'text-danger' : 'text-success';
				$movement['date_movement']          = Tools::formatDate($res['date_movement'], $month, $res['monthly']);
				$movement['monthly']                = $res['monthly'];
				$movement['annual']                 = $res['annual'];
				$movement['name_movement']          = $res['name_movement'];
				$movement['movement_category']      = $res['name_category_movement'];
				$movement['date_begin']             = $res['date_movement'];
				$movement['date_end']               = Tools::formatDate($res['date_end']);
				$movement['nb_month']               = $res['nb_month'];
				$movement['id_movement']            = $res['id_movement'];
				$movement['id_account']             = $res['id_account'];
				$movement['name_user_account']      = $res['name_user_account'];
				$movement['color']                  = $res['color'];
				$movement['id_user_account']        = $res['id_user_account'];;
				$movement['calc_amount']            = (float)$res['amount'];
				$movement['debit']                  = $res['debit'];
				$movement['name_category_movement'] = $res['name_category_movement'];
				$movement['color_movement']         = $res['color_movement'];

				$movements[$res['name_account']][] = $movement;
				$idsAccount[$res['id_account']]    = $res['id_account'];
			}

			return array(
				'movements'  => $movements,
				'idsAccount' => $idsAccount
			);
		}

		public static function getMovementsAccount($idAccount, $dateBegin, $dateEnd, $month)
		{
			$pdo = Db::getInstance();
			$sql = $pdo->query("SELECT m.*, cm.name_category_movement, cm.color as color_movement, ua.id_user_account, ua.name_user_account, ua.color, a.name as name_account
			FROM movement as m 
			LEFT JOIN category_movement as cm ON(m.movement_category = cm.id_category_movement)
			LEFT JOIN user_account as ua ON(m.id_user_account = ua.id_user_account)
			LEFT JOIN account as a ON(m.id_account = a.id_account)
			WHERE m.id_account = ".$idAccount." 
			AND ((m.date_movement BETWEEN '".$dateBegin."' AND '".$dateEnd."')
				OR (m.monthly = 1 
					AND ((m.date_movement < '".$dateEnd."' AND (m.date_end > '".$dateEnd."' OR m.date_end = '0000-00-00'))
					OR (m.annual = 1 OR nb_month >= '".$month."')))
				OR (m.monthly = 2
					AND ((m.date_movement < '".$dateEnd."' AND ('".$month."' % x_month = 1)))
					))
			ORDER BY m.date_movement ASC");

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$movements  = array();
			$idsAccount = array();

			while($res = $sql->fetch())
			{
				$movement['amount']                 = number_format((float)$res['amount'], 2);
				$movement['debit']                  = $res['debit'];
				$movement['color_debit']            = ($res['debit']) ? 'text-danger' : 'text-success';
				$movement['date_movement']          = Tools::formatDate($res['date_movement'], $month, $res['monthly']);
				$movement['monthly']                = $res['monthly'];
				$movement['annual']                 = $res['annual'];
				$movement['name_movement']          = $res['name_movement'];
				$movement['movement_category']      = $res['name_category_movement'];
				$movement['date_begin']             = $res['date_movement'];
				$movement['date_end']               = Tools::formatDate($res['date_end']);
				$movement['nb_month']               = $res['nb_month'];
				$movement['id_movement']            = $res['id_movement'];
				$movement['id_account']             = $res['id_account'];
				$movement['name_user_account']      = $res['name_user_account'];
				$movement['color']                  = $res['color'];
				$movement['id_user_account']        = $res['id_user_account'];;
				$movement['calc_amount']            = (float)$res['amount'];
				$movement['debit']                  = $res['debit'];
				$movement['name_category_movement'] = $res['name_category_movement'];
				$movement['color_movement']         = $res['color_movement'];
				$movement['id_movement_assoc']      = $res['id_movement_assoc'];

				$movements[$res['name_account']][] = $movement;
				$idsAccount[$res['id_account']]    = $res['id_account'];
			}

			return array(
				'movements'  => $movements,
				'idsAccount' => $idsAccount
			);
		}

		public static function getPeriodicMovement($idUser)
		{
			$dateBegin = date("Y-m-d", mktime(0, 0, 0, date("m")  , 1, date("Y")));
			$nbDays    = intval(date("t"));
			$dateEnd   = date("Y-m-d", mktime(0, 0, 0, date("m")  , $nbDays, date("Y")));
			$month     = date("m");

			$pdo = Db::getInstance();

			$sql = $pdo->query("SELECT m.*, cm.name_category_movement, cm.color as color_movement, ua.id_user_account, ua.name_user_account, ua.color, a.name as name_account
			FROM movement as m 
			LEFT JOIN category_movement as cm ON(m.movement_category = cm.id_category_movement)
			LEFT JOIN user_account as ua ON(m.id_user_account = ua.id_user_account)
			LEFT JOIN account as a ON(m.id_account = a.id_account)
			WHERE m.id_user = ".$_SESSION['id_user']." 
			AND (m.monthly = 1 AND (m.date_movement < '".$dateEnd."' AND (m.date_end > '".$dateEnd."' OR m.date_end = '0000-00-00'))
				OR (m.annual = 1 OR nb_month >= '".$month."'))
			ORDER BY m.date_movement ASC");

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$movements  = array();

			while($res = $sql->fetch())
			{
				$movement['id_movement']            = $res['id_movement'];
				$movement['id_account']             = $res['id_account'];
				$movement['name_user_account']      = $res['name_user_account'];
				$movement['color']                  = $res['color'];
				$movement['id_user_account']        = $res['id_user_account'];;
				$movement['calc_amount']            = (float)$res['amount'];
				$movement['debit']                  = $res['debit'];
				$movement['name_category_movement'] = $res['name_category_movement'];
				$movement['color_movement']         = $res['color_movement'];

				$movements[$res['name_account']][] = $movement;
			}

			return  $movements;
		}

		public static function getMovement($idMovement)
		{
			return Db::select('movement', '*', array('id_movement' => array(PDO::PARAM_INT => $idMovement)));
		}
		
		public static function deleteMovement($idMovement)
		{
			$where = array(
				'id_movement' => array(PDO::PARAM_INT => $idMovement),
			);

			return Db::delete('movement', $where);
		}

		public static function deleteAccountMovement($idAccount)
		{
			$where = array(
				'id_account' => array(PDO::PARAM_INT => $idAccount),
			);

			return Db::delete('movement', $where);
		}

		public static function deleteUserAccountMovement($idUserAccount)
		{
			$where = array(
				'id_user_account' => array(PDO::PARAM_INT => $idUserAccount),
			);

			return Db::delete('movement', $where);
		}

		public static function deleteUserMovement($idUser)
		{
			$where = array(
				'id_user' => array(PDO::PARAM_INT => $idUser),
			);

			return Db::delete('movement', $where);
		}

		public static function updateMovement($idMovement, $idUser, $amount, $dateMovement, $name, $category, $dateEnd)
		{
			$fields = array(
				'amount'            => array(PDO::PARAM_STR => $amount),
				'date_movement'     => array(PDO::PARAM_STR => $dateMovement),
				'name_movement'     => array(PDO::PARAM_STR => $name),
				'id_user_account'   => array(PDO::PARAM_INT => $idUser),
				'movement_category' => array(PDO::PARAM_INT => $category),
				'date_end'          => array(PDO::PARAM_STR => $dateEnd),
			);

			$where = array(
				'id_movement' => array(PDO::PARAM_INT => $idMovement),
			);

			return Db::update('movement', $fields, $where);
		}

		public static function updateMovementAssoc($idMovement, $idMovementAssoc)
		{
			$fields = array(
				'id_movement_assoc' => array(PDO::PARAM_INT => $idMovementAssoc),
			);

			$where = array(
				'id_movement' => array(PDO::PARAM_INT => $idMovement),
			);

			return Db::update('movement', $fields, $where);
		}

		public static function addMovement($idUser, $idAccount, $idUserAccount, $amount, $debit, $dateMovement, $monthly, $xMonth, $annual, $nameAccount, $movementCategory, $dateEnd, $nbMonth, $idMovementAssoc=0)
		{

			$fields = array(
				'id_user'           => array(PDO::PARAM_INT => $idUser),
				'id_account'        => array(PDO::PARAM_STR => $idAccount),
				'id_user_account'   => array(PDO::PARAM_INT => $idUserAccount),
				'amount'            => array(PDO::PARAM_STR => $amount),
				'debit'             => array(PDO::PARAM_STR => $debit),
				'date_movement'     => array(PDO::PARAM_STR => $dateMovement),
				'monthly'           => array(PDO::PARAM_STR => $monthly),
				'x_month'           => array(PDO::PARAM_STR => $xMonth),
				'annual'            => array(PDO::PARAM_STR => $annual),
				'name_movement'     => array(PDO::PARAM_STR => $nameAccount),
				'movement_category' => array(PDO::PARAM_STR => $movementCategory),
				'date_end'          => array(PDO::PARAM_STR => $dateEnd),
				'nb_month'          => array(PDO::PARAM_STR => $nbMonth),
				'id_movement_assoc' => array(PDO::PARAM_INT => $idMovementAssoc),
			);

			return Db::insert('movement', $fields);
		}

		public static function getYearsMovement($idUser)
		{
			$pdo = Db::getInstance();

			$sql = $pdo->query("SELECT DISTINCT date_movement
			FROM movement 
			WHERE id_user = ".$idUser);

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$years = array();
			while($res = $sql->fetch())
			{
				$date = explode("-", $res['date_movement']);
				$years[] = $date[0];
			}

			return $years;
		}
	}