<?php

	class Admin{

		private $id_admin, $first_name, $last_name, $mail, $password, $account;

		public function __construct($id=null)
		{
			if ($id)
			{
				$db    = Db::getInstance();
				$pdo   = $db->query("SELECT * FROM admin WHERE id_admin = ".$id);
				$admin = $pdo->fetch(PDO::FETCH_OBJ);

				$this->id_admin   = $admin->id_admin;
				$this->first_name = $admin->first_name;
				$this->last_name  = $admin->last_name;
				$this->mail       = $admin->mail;
				$this->account    = $admin->account;
				$this->account    = $admin->account;
			}
			
		}

		/**
		 * Check if new mail.
		 *
		 * @params string $mail mail to check
		 *
		 * return boolean.
		 */
		public static function isNewMail($mail)
		{
			$newMail = Db::select('admin', 'mail', array('mail' => array(PDO::PARAM_STR => $mail)));

			if ($newMail && isset($newMail->mail))
				return false;
			
			return true;
		}

		/**
		 * Return info for mail admin
		 *
		 * @params string $mail    admin mail
		 * @params string $password admin password
		 *
		 * return void.
		 */
		public static function getInfoMail($mail, $password)
		{
			$where = array(
				'mail'     => array(PDO::PARAM_STR => $mail),
				'password' => array(PDO::PARAM_STR => md5($password))
			);

			$info = Db::select('admin', '*', $where);

			if ($info)
				return $info;

			return false;
		}

		/**
		 * Add new admin in db
		 *
		 * @params string $firstName First name
		 * @params string $lastName  Last name
		 * @params string $mail     mail
		 * @params string $password  Password
		 * @params string $account   Nb account
		 *
		 * return boolean.
		 */
		public static function addNewAdmin($firstName, $lastName, $mail, $password, $account)
		{
			$fields = array(
				'first_name' => array(PDO::PARAM_STR => $firstName),
				'last_name'  => array(PDO::PARAM_STR => $lastName),
				'mail'       => array(PDO::PARAM_STR => $mail),
				'password'   => array(PDO::PARAM_STR => $password),
				'account'    => array(PDO::PARAM_INT => $account),
			);

			return Db::insert('admin', $fields);
		}

		/**
		 * Return info admin
		 *
		 * @params string $firstName admin first name
		 * @params string $lastName  admin last name
		 * @params string $mail     admin mail
		 *
		 * return void.
		 */
		public static function getInfoAdminWithNameAndMail($firstName, $lastName, $mail)
		{
			$where = array(
				'first_name' => array(PDO::PARAM_STR => $firstName),
				'last_name'  => array(PDO::PARAM_STR => $lastName),
				'mail'       => array(PDO::PARAM_STR => $mail)
			);

			$info = Db::select('admin', '*', $where);

			if ($info)
				return $info;

			return false;
		}

		public static function getPassword($idAdmin, $password)
		{
			$where = array(
				'id_admin'  => array(PDO::PARAM_INT => $idAdmin),
				'password' => array(PDO::PARAM_STR => md5($password))
			);

			return Db::select('admin', 'password', $where);
		}

		public static function updateAdminPassword($idAdmin, $password)
		{
			$fields = array(
				'password'  => array(PDO::PARAM_STR => md5($password)),
			);

			$where = array(
				'id_admin' => array(PDO::PARAM_INT => $idAdmin),
			);

			return Db::update('admin', $fields, $where);
		}
	}