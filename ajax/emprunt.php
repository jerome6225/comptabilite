<?php
	include dirname(__FILE__)."/../include.php";

	$date = explode('-', $_POST['date']);
	$emprunt = Emprunt::addEmprunt($_SESSION['id_user'], htmlentities($_POST['name']), $date[2].'-'.$date[1].'-'.$date[0], $_POST['somme'], $_POST['remboursement'], $_POST['etalonnement'], 0);

	if ($emprunt)
	{
		if ($_POST['remboursement'] != '')
		{
			$etalonnement = (int)$_POST['somme'] / (int)$_POST['remboursement'];
			for ($i=1;$i<=$etalonnement;$i++)
				Remboursement::addRemboursement($emprunt, $_POST['remboursement'], $date[2].'-'.(date('m') + $i).'-'.$date[0]);
		}
		else
		{
			$montantRemboursement = (int)$_POST['somme'] / (int)$_POST['etalonnement'];
			for ($i=1;$i<=(int)$_POST['etalonnement'];$i++)
				Remboursement::addRemboursement($emprunt, $montantRemboursement, $date[2].'-'.(date('m') + $i).'-'.$date[0]);
		}

		echo 'ok';
		exit;
	}
	else
	{
		echo 'error';
		exit;
	}