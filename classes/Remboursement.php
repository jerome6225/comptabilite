<?php

	class Remboursement{

		private $id_remboursement, $id_emprunt, $montant, $date;

		public function __construct($id=null)
		{
			if ($id)
			{
				$db   = Db::getInstance();
				$pdo  = $db->query("SELECT * FROM remboursement WHERE id_remboursement = ".$id);
				$user = $pdo->fetch(PDO::FETCH_OBJ);

				$this->id_remboursement = $user->id_remboursement;
				$this->id_emprunt       = $user->id_emprunt;
				$this->montant          = $user->montant;
				$this->date             = $user->date;
			}
			
		}


		/**
		 * Return info for remboursement user
		 *
		 * @params string $id_emprunt id emprunt
		 *
		 * return void.
		 */
		public static function getRemboursements($id_emprunt)
		{
			$where = array(
				'id_emprunt' => array(PDO::PARAM_STR => $id_emprunt)
			);

			$info = Db::select('remboursement', '*', $where, false);

			if ($info)
				return $info;

			return false;
		}

		/**
		 * Add new emprunt in db
		 *
		 * @params int    $idUser               Id user
		 * @params string $nomEmprunt           Nom
		 * @params date   $dateEmprunt          Date
		 * @params string $montantEmprunt       Montant
		 * @params string $montantRemboursement Montant du remboursement
		 * @params int    $etalonnement         Etalonnement
		 * @params bool   $termine              Termine
		 *
		 * return boolean.
		 */
		public static function addRemboursement($idEmprunt, $montant, $date)
		{
			$fields = array(
				'id_emprunt' => array(PDO::PARAM_INT => $idEmprunt),
				'montant'    => array(PDO::PARAM_STR => $montant),
				'date'       => array(PDO::PARAM_STR => $date),
			);

			return Db::insert('remboursement', $fields);
		}

		/**
		 * Update emprunt in db
		 *
		 * @params int    $idUser               Id user
		 * @params string $nomEmprunt           Nom
		 * @params date   $dateEmprunt          Date
		 * @params string $montantEmprunt       Montant
		 * @params string $montantRemboursement Montant du remboursement
		 * @params int    $etalonnement         Etalonnement
		 * @params bool   $termine              Termine
		 *
		 * return boolean.
		 */
		public static function updateRemboursement($idRemboursement, $idEmprunt, $montant, $date)
		{
			$fields = array(
				'id_emprunt' => array(PDO::PARAM_STR => $idEmprunt),
				'montant'    => array(PDO::PARAM_STR => $montant),
				'date'       => array(PDO::PARAM_INT => $date),
			);

			$where = array(
				'id_remboursement' => array(PDO::PARAM_INT => $idRemboursement),
			);

			return Db::update('remboursement', $fields, $where);
		}

		public static function updateStatusRemboursement($idRemboursement, $status)
		{
			$fields = array(
				'effectue' => array(PDO::PARAM_INT => $status),
			);

			$where = array(
				'id_remboursement' => array(PDO::PARAM_INT => $idRemboursement),
			);

			return Db::update('remboursement', $fields, $where);
		}

		public static function deleteRemboursement($idEmprunt)
		{
			$where = array(
				'id_emprunt' => array(PDO::PARAM_INT => $idEmprunt),
			);

			return Db::delete('remboursement', $where);
		}
	}