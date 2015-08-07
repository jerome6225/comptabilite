<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<!-- favicon -->
	<link rel="shortcut icon" href="img/favicons/favicon.ico" type="image/x-icon">
	<link rel="icon" href="img/favicons/favicon.png" type="image/png">
	<link rel="icon" sizes="32x32" href="img/favicons/favicon-32.png" type="image/png">
	<link rel="icon" sizes="64x64" href="img/favicons/favicon-64.png" type="image/png">
	<link rel="icon" sizes="96x96" href="img/favicons/favicon-96.png" type="image/png">
	<!-- /favicon -->

	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
	<script type="text/javascript" src="js/jquery-datepicker.min.js"></script>
	<script type="text/javascript" src="js/tab.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/global.css">

	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<title>Comptabilit&eacute;</title>

</head>
<body data-spy="scroll" data-target="#navbar-defile">
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<div id="img_loader" style="display: none;"></div>

	<div class="container">
		<img src="img/banniere.png" class="banniere_size" alt="banniere ma compta" />
		<?php include "menu.php" ?>