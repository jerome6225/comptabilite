<?php

	class User{

		private $id_user, $first_name, $last_name, $login, $password, $account;

		public function __construct($id=null)
		{
			if ($id)
			{
				$db   = Db::getInstance();
				$pdo  = $db->query("SELECT * FROM user WHERE id_user = ".$id);
				$user = $pdo->fetch(PDO::FETCH_OBJ);

				$this->id_user    = $user->id_user;
				$this->first_name = $user->first_name;
				$this->last_name  = $user->last_name;
				$this->login      = $user->login;
				$this->account    = $user->account;
				$this->account    = $user->account;
			}
			
		}

		/**
		 * Check if new login.
		 *
		 * @params string $login login to check
		 *
		 * return boolean.
		 */
		public static function isNewLogin($login)
		{
			$newLogin = Db::select('user', 'login', array('login' => array(PDO::PARAM_STR => $login)));

			if ($newLogin && isset($newLogin->login))
				return false;
			
			return true;
		}

		/**
		 * Return info for login user
		 *
		 * @params string $login    user login
		 * @params string $password user password
		 *
		 * return void.
		 */
		public static function getInfoLogin($login, $password)
		{
			$where = array(
				'login'    => array(PDO::PARAM_STR => $login),
				'password' => array(PDO::PARAM_STR => md5($password))
			);

			$info = Db::select('user', '*', $where);

			if ($info)
				return $info;

			return false;
		}

		/**
		 * Add new user in db
		 *
		 * @params string $firstName First name
		 * @params string $lastName  Last name
		 * @params string $login     Login
		 * @params string $password  Password
		 * @params string $account   Nb account
		 *
		 * return boolean.
		 */
		public static function addNewUser($firstName, $lastName, $login, $password, $account)
		{
			$fields = array(
				'first_name' => array(PDO::PARAM_STR => $firstName),
				'last_name'  => array(PDO::PARAM_STR => $lastName),
				'login'      => array(PDO::PARAM_STR => $login),
				'password'   => array(PDO::PARAM_STR => $password),
				'account'    => array(PDO::PARAM_INT => $account),
			);

			return Db::insert('user', $fields);
		}

		/**
		 * Return info user
		 *
		 * @params string $firstName user first name
		 * @params string $lastName  user last name
		 * @params string $login     user login
		 *
		 * return void.
		 */
		public static function getInfoUserWithNameAndlogin($firstName, $lastName, $login)
		{
			$where = array(
				'first_name' => array(PDO::PARAM_STR => $firstName),
				'last_name' => array(PDO::PARAM_STR => $lastName),
				'login'    => array(PDO::PARAM_STR => $login)
			);

			$info = Db::select('user', '*', $where);

			if ($info)
				return $info;

			return false;
		}

		public static function getPassword($idUser, $password)
		{
			$where = array(
				'id_user'  => array(PDO::PARAM_INT => $idUser),
				'password' => array(PDO::PARAM_STR => md5($password))
			);

			return Db::select('user', 'password', $where);
		}

		public static function updateUserPassword($idUser, $password)
		{
			$fields = array(
				'password'  => array(PDO::PARAM_STR => md5($password)),
			);

			$where = array(
				'id_user' => array(PDO::PARAM_INT => $idUser),
			);

			return Db::update('user', $fields, $where);
		}
	}