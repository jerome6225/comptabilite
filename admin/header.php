<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
	<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
	<script type="text/javascript" src="../js/jquery-datepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.css">
	<title>Admin Comptabilit&eacute;</title>
</head>
<body id="body_admin">
	<div id="background_banner"><div>
	<div id="global">
		<?php if (isset($_SESSION['id_admin'])){ ?>
			<div id="block_customer">
				Bonjour <?php echo $_SESSION['first_name']." ".$_SESSION['last_name'] ?><br />
				<a href="/comptabilite/admin/logout.php">D&eacute;connexion</a>
			</div>
		<?php } ?>

		<?php include "menu.php" ?>