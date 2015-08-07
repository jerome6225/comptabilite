<?php

	class AccountBalance{

		private $id_account_balance, $id_account, $current_balance, $balance_total;

		public function __construct($id=null)
		{
			if ($id)
			{
				$accountBalance = Db::select('account_balance', '*', array('id_account_balance' => array(PDO::PARAM_INT => $id)));

				$this->id_account_balance = $accountBalance->id_account_balance;
				$this->id_account         = $accountBalance->id_account;
				$this->current_balance    = $accountBalance->current_balance;
				$this->balance_total      = $accountBalance->balance_total;
			}
		}

		public static function addNewAccountBalance($idAccount, $currentBalance, $balanceTotal)
		{
			$fields = array(
				'id_account'      => array(PDO::PARAM_INT => $idAccount),
				'current_balance' => array(PDO::PARAM_STR => $currentBalance),
				'balance_total'   => array(PDO::PARAM_INT => $balanceTotal)
			);

			return Db::insert('account_balance', $fields);
		}

		public static function getAccountBalance($idAccount)
		{
			$accountBalance = Db::select('account_balance', '*', array('id_account' => array(PDO::PARAM_INT => $idAccount)));

			if ($accountBalance)
				return $accountBalance;

			return false;
		}

		public static function updateAccountBalance($idAccount, $currentBalance, $balanceTotal)
		{
			$fields = array(
				'current_balance'  => array(PDO::PARAM_STR => $currentBalance),
				'balance_total'  => array(PDO::PARAM_STR => $balanceTotal),
			);

			$where = array(
				'id_account' => array(PDO::PARAM_INT => $idAccount),
			);

			$accountBalance = Db::update('account_balance', $fields, $where);
		}

		public static function deleteAccountBalance($idAccount)
		{
			$where = array(
				'id_account' => array(PDO::PARAM_INT => $idAccount),
			);

			return Db::delete('account_balance', $where);
		}
	}