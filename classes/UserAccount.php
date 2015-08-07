<?php

	class UserAccount{

		private $id_user_account, $id_user, $name_user_account, $picture, $color;

		public function __construct($id=null)
		{
			if ($id)
			{
				$userAccount = Db::select('user_account', '*', array('id_user_account' => array(PDO::PARAM_INT => $id)));

				$this->id_user_account   = $userAccount->id_user;
				$this->id_user           = $userAccount->first_name;
				$this->name_user_account = $userAccount->last_name;
				$this->picture           = $userAccount->login;
				$this->color             = $userAccount->account;
			}
		}

		public static function addNewUserAccount($idUser, $userName, $userColor)
		{
			$fields = array(
				'id_user'           => array(PDO::PARAM_INT => $idUser),
				'name_user_account' => array(PDO::PARAM_STR => $userName),
				'color'             => array(PDO::PARAM_STR => $userColor),
			);

			return Db::insert('user_account', $fields);
		}

		public static function getUsersAccount($idUser)
		{
			$usersAccount = Db::select('user_account', '*', array('id_user' => array(PDO::PARAM_INT => $idUser)), false);

			if ($usersAccount)
				return $usersAccount;

			return false;
		}

		public static function getUserAccount($idUserAccount)
		{
			return Db::select('user_account', '*', array('id_user_account' => array(PDO::PARAM_INT => $idUserAccount)));
		}

		public static function updateUserAccount($idUserAccount, $nameUserAccount, $color)
		{
			$fields = array(
				'name_user_account' => array(PDO::PARAM_STR => $nameUserAccount),
				'color'             => array(PDO::PARAM_STR => $color),
			);

			$where = array(
				'id_user_account' => array(PDO::PARAM_INT => $idUserAccount),
			);

			return Db::update('user_account', $fields, $where);
		}

		public static function deleteUserAccount($idUserAccount)
		{
			$where = array(
				'id_user_account' => array(PDO::PARAM_INT => $idUserAccount),
			);

			return Db::delete('user_account', $where);
		}
	}