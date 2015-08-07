<?php

	class Account{

		private $id_account, $id_user, $name, $type_account, $user_account;

		public function __construct($id=null)
		{
			if ($id)
			{
				$account = Db::select('account', '*', array('id_account' => array(PDO::PARAM_INT => $id)));

				$this->id_account   = $account->id_account;
				$this->id_user      = $account->id_user;
				$this->name         = $account->name;
				$this->type_account = $account->type_account;
				$this->user_account = $account->user_account;
			}
		}

		public static function addNewAccount($idUser, $name, $typeAccount, $userAccount)
		{
			$fields = array(
				'id_user'      => array(PDO::PARAM_INT => $idUser),
				'name'         => array(PDO::PARAM_STR => $name),
				'type_account' => array(PDO::PARAM_INT => $typeAccount),
				'user_account' => array(PDO::PARAM_STR => $userAccount)
			);

			return Db::insert('account', $fields);
		}

		public static function getAccounts($idUser)
		{
			return Db::select('account', '*', array('id_user' => array(PDO::PARAM_INT => $idUser)), false);
		}

		public static function getAccount($idAccount)
		{
			return Db::select('account', '*', array('id_account' => array(PDO::PARAM_INT => $idAccount)));
		}

		public static function updateAccount($idAccount, $name, $typeAccount, $userAccount)
		{
			$fields = array(
				'name'         => array(PDO::PARAM_STR => $name),
				'type_account' => array(PDO::PARAM_INT => $typeAccount),
				'user_account' => array(PDO::PARAM_INT => $userAccount),
			);

			$where = array(
				'id_account' => array(PDO::PARAM_INT => $idAccount),
			);

			return Db::update('account', $fields, $where);
		}

		public static function deleteAccount($idAccount)
		{
			$where = array(
				'id_account' => array(PDO::PARAM_INT => $idAccount),
			);

			return Db::delete('account', $where);
		}
	}