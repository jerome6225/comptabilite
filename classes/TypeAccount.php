<?php

	class TypeAccount{

		private $id_type_account, $name_type_account;

		public function __construct(){}

		public static function getTypesAccount()
		{
			$typesAccount = Db::select('type_account', '*', '', false);

			return $typesAccount;
		}
	}