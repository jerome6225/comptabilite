<?php
	$emprunts = Emprunt::getEmprunts($_SESSION['id_user']);

	if ($emprunts)
	{
		$listEmprunts = array();
		foreach ($emprunts as $emprunt)
		{
			$remboursements = Remboursement::getRemboursements($emprunt['id_emprunt']);

			$date = explode('-', $emprunt['date_emprunt']);

			$listEmprunts[$emprunt['id_emprunt']]['name']              = $emprunt['nom_emprunt'];
			$listEmprunts[$emprunt['id_emprunt']]['date']              = $date[2].'-'.$date[1].'-'.$date[0];
			$listEmprunts[$emprunt['id_emprunt']]['montant']           = $emprunt['montant_emprunt'];
			$listEmprunts[$emprunt['id_emprunt']]['remboursement']     = $emprunt['montant_remboursement'];
			$listEmprunts[$emprunt['id_emprunt']]['etalonnement']      = $emprunt['etalonnement'];
			$listEmprunts[$emprunt['id_emprunt']]['termine']           = $emprunt['termine'];
			$listEmprunts[$emprunt['id_emprunt']]['listRemboursement'] = array();

			if ($remboursements)
				$listEmprunts[$emprunt['id_emprunt']]['listRemboursement'] = $remboursements;
		}
	}