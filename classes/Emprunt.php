<?php

	class Emprunt{

		private $id_emprunt, $id_user, $nom_emprunt, $date_emprunt, $montant_emprunt, $montant_remboursement, $etalonnement, $termine;

		public function __construct($id=null)
		{
			if ($id)
			{
				$db   = Db::getInstance();
				$pdo  = $db->query("SELECT * FROM emprunt WHERE id_emprunt = ".$id);
				$user = $pdo->fetch(PDO::FETCH_OBJ);

				$this->id_emprunt            = $user->id_emprunt;
				$this->id_user               = $user->id_user;
				$this->nom_emprunt           = $user->nom_emprunt;
				$this->date_emprunt          = $user->date_emprunt;
				$this->montant_emprunt       = $user->montant_emprunt;
				$this->montant_remboursement = $user->montant_remboursement;
				$this->etalonnement          = $user->etalonnement;
				$this->termine               = $user->termine;
			}
			
		}


		/**
		 * Return info for emprunt user
		 *
		 * @params string $id_emprunt id emprunt
		 * @params string $id_user    id user
		 *
		 * return void.
		 */
		public static function getEmprunts($id_user)
		{
			$where = array(
				'id_user' => array(PDO::PARAM_STR => $id_user)
			);

			$info = Db::select('emprunt', '*', $where, false);

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
		public static function addEmprunt($idUser, $nomEmprunt, $dateEmprunt, $montantEmprunt, $montantRemboursement, $etalonnement, $termine)
		{
			$fields = array(
				'id_user'               => array(PDO::PARAM_INT => $idUser),
				'nom_emprunt'           => array(PDO::PARAM_STR => $nomEmprunt),
				'date_emprunt'          => array(PDO::PARAM_STR => $dateEmprunt),
				'montant_emprunt'       => array(PDO::PARAM_STR => $montantEmprunt),
				'montant_remboursement' => array(PDO::PARAM_INT => $montantRemboursement),
				'etalonnement'          => array(PDO::PARAM_INT => $etalonnement),
				'termine'               => array(PDO::PARAM_BOOL => $termine),
			);

			return Db::insert('emprunt', $fields);
		}

		/**
		 * Update emprunt in db
		 *
		 * @params int    $idEmprunt            Id emprunt
		 * @params string $nomEmprunt           Nom
		 * @params date   $dateEmprunt          Date
		 * @params string $montantEmprunt       Montant
		 * @params string $montantRemboursement Montant du remboursement
		 * @params int    $etalonnement         Etalonnement
		 * @params bool   $termine              Termine
		 *
		 * return boolean.
		 */
		public static function updateEmprunt($idEmprunt, $nomEmprunt, $dateEmprunt, $montantEmprunt, $montantRemboursement, $etalonnement, $termine)
		{
			$fields = array(
				'nom_emprunt'           => array(PDO::PARAM_STR => $nomEmprunt),
				'date_emprunt'          => array(PDO::PARAM_STR => $dateEmprunt),
				'montant_emprunt'       => array(PDO::PARAM_STR => $montantEmprunt),
				'montant_remboursement' => array(PDO::PARAM_INT => $montantRemboursement),
				'etalonnement'          => array(PDO::PARAM_INT => $etalonnement),
				'termine'               => array(PDO::PARAM_BOOL => $termine),
			);

			$where = array(
				'id_emprunt' => array(PDO::PARAM_INT => $idEmprunt),
			);

			return Db::update('user', $fields, $where);
		}
	}