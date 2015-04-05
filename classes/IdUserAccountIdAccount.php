<?php
	
	class IdUserAccountIdAccount{

		public function __construct(){}

		public static function addIdUserAccountIdAccount($idUser, $idAccount)
		{
			$fields = array(
				'id_user_account' => array(PDO::PARAM_INT => $idUser),
				'id_account'      => array(PDO::PARAM_INT => $idAccount)
			);

			if (Db::insert('id_user_account_id_account', $fields) === "0")
				return true;

			return false;
		}

		public static function getUsersAccount($idAccount)
		{
			$db = Db::getInstance();

			$sql = $db->query("SELECT iuaia.id_user_account, ua.name_user_account FROM id_user_account_id_account as iuaia
				LEFT JOIN user_account as ua ON (iuaia.id_user_account = ua.id_user_account)
				WHERE iuaia.id_account = ".$idAccount);

			$sql->setFetchMode(PDO::FETCH_ASSOC);

			$users = array();

			while($res = $sql->fetch())
			{
				$user['id']   = $res['id_user_account'];
				$user['name'] = $res['name_user_account'];

				$users[] = $user;
			}

			return $users;
		}

		public static function deleteWithIdAccount($idAccount)
		{
			$where = array(
				'id_account' => array(PDO::PARAM_INT => $idAccount),
			);

			return Db::delete('id_user_account_id_account', $where);
		}
	}